<?php


namespace App\Http\Controllers\Emulators;


use Illuminate\Support\Facades\Log;

class MT2TuringMachine
{
    // [
    //   {
    //     state: 'S0',
    //     expressions: {
    //       '0': 'R',
    //       '1': 'R',
    //       [lambdaSymbol]: `${lambdaSymbol} L s1`,
    //     }
    //   }
    // ]
    private $automaton;
    private $alphabet;
    private $tape;
    private $firstState;
    private $lambdaSymbol;
    private $lastCommandSymbol;
    private $RSymbol;
    private $NSymbol;
    private $LSymbol;

    public function __construct($automaton, $alphabet) {
        $this->firstState = 'S0';
        $this->lambdaSymbol = 'λ';
        $this->lastCommandSymbol = 'Ω';
        $this->automaton = $automaton;
        $this->alphabet = $alphabet;
        $this->tape = null;
        $this->RSymbol = 'R';
        $this->LSymbol = 'L';
        $this->NSymbol = 'H';
    }

    public function run($input) {
        $this->tape = new MT2TapeWithPos($input);
        $itersCount = $this->runInternal();
        $output = $this->tape->asString();
        $this->tape = null;
        return [
            'cycle' => $itersCount,
            'result' => $output,
        ];
    }

    private function runInternal() {
        $state = $this->firstState;
        $errors = $this->getErrors();
        if (count($errors) > 0) {
            return 0;
        }
        $itersCount = 500;
        $stopReason = 'too-many-commands';
        for ($i = 0; $i < $itersCount; $i++) {
            $automatonRow = $this->findRowByState($state);
            if ($automatonRow === null) {
                return 0;
            }
            $automatonExpressions = $automatonRow['expressions'];
            $tapeChar = $this->tape->getChar();
            if (array_key_exists($tapeChar, $automatonExpressions)) {
                $command = $automatonExpressions[$tapeChar];
            } else {
                $command = '';
            }
            $parsedCommand = $this->parseCommand($command, $state);

            $fillCharOnTape = $parsedCommand['fillCharOnTape'];
            $tapeMovement = $parsedCommand['tapeMovement'];
            $nextState = $parsedCommand['nextState'];
            if ($tapeMovement == $this->NSymbol && $nextState == $state && $fillCharOnTape == $tapeChar) {
                $itersCount = $i;
                $stopReason = 'empty-rule';
                break;
            }

            $state = $this->applyCommand($parsedCommand);
            if ($this->tape->getPos() < 0) {
                $stopReason = 'outside-the-tape';
                break;
            }
            if ($parsedCommand['nextState'] === $this->lastCommandSymbol) {
                $stopReason = 'successful-finish';
                $itersCount = $i + 1;
                break;
            }
        }
        if ($stopReason == 'too-many-commands') {
            $errors[] = "Машина была остановлена, т.к. за $itersCount команд не было найдено команды с переходом в конечное состояние ($this->lastCommandSymbol).";
        } else if ($stopReason == 'empty-rule') {
            $errors[] = "Машина была остановлена, т.к. спустя $itersCount команд была встречена команда, не влияющая на машину.";
        } else if ($stopReason == 'outside-the-tape') {
            $errors[] = "Машина была остановлена, т.к. был произведён переход за пределы однонаправленной ленты.";
        }
        return $itersCount;
    }

    private function findRowByState($state) {
        foreach ($this->automaton as $row) {
            if ($row['state'] === $state) {
                return $row;
            }
        }
        return null;
    }

    private function parseCommand($command, $currentState) {
        $fillCharOnTape = $this->tape->getChar();
        $tapeMovement = $this->NSymbol;
        $nextState = $currentState;
        $parts = preg_replace('/\s+/u', ' ', $command);
        $parts = preg_split('/ /u', trim($parts));
        if (count($parts) === 1) {
            if ($parts[0] === $this->RSymbol) {
                $tapeMovement = $this->RSymbol;
            } else if ($parts[0] === $this->LSymbol) {
                $tapeMovement = $this->LSymbol;
            }
        } else {
            $fillCharOnTape = $parts[0];
            if ($parts[1] === $this->RSymbol) {
                $tapeMovement = $this->RSymbol;
            } else if ($parts[1] === $this->LSymbol) {
                $tapeMovement = $this->LSymbol;
            }
            $nextState = $parts[2];
        }
        return [
            'fillCharOnTape' => $fillCharOnTape,
            'tapeMovement' => $tapeMovement,
            'nextState' => $nextState,
        ];
    }

    private function applyCommand($parsedCommand) {
        $fillCharOnTape = $parsedCommand['fillCharOnTape'];
        $tapeMovement = $parsedCommand['tapeMovement'];
        $nextState = $parsedCommand['nextState'];
        $this->tape->setChar($fillCharOnTape);
        if ($tapeMovement === $this->RSymbol) {
            $this->tape->toRight();
        } else if ($tapeMovement === $this->LSymbol) {
            $this->tape->toLeft();
        }
        if ($nextState === $this->lastCommandSymbol) {
            return $this->firstState;
        } else {
            return $nextState;
        }
    }

    private function getErrors() {
        $tapeErrors = $this->getTapeErrors();
        $statesErrors = $this->getStatesErrors();
        $commandsErrors = $this->getCommandsErrors();
        return array_merge($tapeErrors, $statesErrors, $commandsErrors);
    }

    private function getTapeErrors() {
        return $this->tape->getAlphabetErrors($this->alphabet);
    }

    private function getStatesErrors() {
        $res = [];
        $allStates = [];
        $firstStateExists = false;
        foreach ($this->automaton as $row) {
            $state = $row['state'];
            if ($state === $this->firstState) {
                $firstStateExists = true;
            }
            if (in_array($state, $allStates)) {
                $res[] = "Состояние \"$state\" повторяется более одного раза в таблице.";
            } else {
                $allStates[] = $state;
            }
        }
        if (!$firstStateExists) {
            $res[] = "В таблице должно присутствовать начальное состояние с названием \"$this->firstState\".";
        }
        return $res;
    }

    private function getCommandsErrors() {
        $res = [];
        foreach ($this->automaton as $row) {
            foreach ($row['expressions'] as $symbol => $command) {
                $errors = $this->getOneCommandErrors($command);
                foreach ($errors as $error) {
                    $res[] = "Состояние \"${$row['state']}\" символ '$symbol': $error";
                }
            }
        }
        return $res;
    }

    private function getOneCommandErrors($command) {
        $res = [];
        $parts = preg_replace('/\s+/u', ' ', $command);
        $parts = preg_split('/ /u', trim($parts));
        if (count($parts) !== 1 && count($parts) !== 3) {
            $lenParts = count($parts);
            $res[] = "команда должна иметь 1 или 3 элемента разделённых пробелами. У Вас команда имеет $lenParts элементов, разделённых пробелами.";
            return $res;
        }
        if (count($parts) === 1) {
            $part = $parts[0];
            if ($part !== '' && $part !== $this->RSymbol && $part !== $this->LSymbol && $part !== $this->NSymbol) {
                $res[] = "элемент должен иметь значение '$this->RSymbol', '$this->LSymbol', '$this->NSymbol' или быть не заданным. Сейчас задано '$part'.";
                return $res;
            }
        } else {
            $left = $parts[0];
            $middle = $parts[1];
            $right = $parts[2];
            if (!(in_array($left, $this->alphabet) || $left === $this->lambdaSymbol)) {
                $alphabetStr = join('', $this->alphabet);
                $res[] = "первый элемент должен быть символом алфавита \"$alphabetStr\" или символом $this->lambdaSymbol. Сейчас первый элемент имеет значение \"$left\".";
            }
            if ($middle !== $this->RSymbol && $middle !== $this->LSymbol && $middle !== $this->NSymbol) {
                $res[] = "средний элемент должен иметь значение '$this->RSymbol', '$this->LSymbol' или '$this->NSymbol'. Сейчас задано '$middle'.";
            }
            $mapped = array_map(function($x) {
                return $x['state'];
            }, $this->automaton);
            if (!(in_array($right, $mapped) || $right === $this->lastCommandSymbol)) {
                $res[] = "последний элемент должен являться состоянием или являться символом '" . $this->lastCommandSymbol . "', обозначающим конец. Сейчас последний элемент имеет значение \"$right\".";
            }
        }
        return $res;
    }
}