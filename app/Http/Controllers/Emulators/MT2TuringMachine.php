<?php


namespace App\Http\Controllers\Emulators;


use Illuminate\Support\Facades\Log;

class MT2TuringMachine
{
    // [
    //   {
    //     state: 's0',
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

    public function __construct($automaton, $alphabet) {
        $this->firstState = 's0';
        $this->lambdaSymbol = 'η';
        $this->lastCommandSymbol = 'Ω';
        $this->automaton = $automaton;
        $this->alphabet = $alphabet;
        $this->tape = null;
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
        Log::debug('errors');
        Log::debug($errors);
        if (count($errors) > 0) {
            return 0;
        }
        $itersCount = 500;
        $all_ok = false;
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
            $state = $this->applyCommand($parsedCommand);
            if ($parsedCommand['nextState'] === $this->lastCommandSymbol) {
                $all_ok = true;
                $itersCount = $i + 1;
                break;
            }
        }
        if (!$all_ok) {
            $errors[] = "Следующий шаг был выполнен $itersCount раз, но не было найдено команды, обозначающей конец, поэтому машина была приостановлена.";
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
        $tapeMovement = 'N';
        $nextState = $currentState;
        $parts = preg_replace('/\s+/u', ' ', $command);
        $parts = preg_split('/ /u', trim($parts));
        if (count($parts) === 1) {
            if ($parts[0] === 'R') {
                $tapeMovement = 'R';
            } else if ($parts[0] === 'L') {
                $tapeMovement = 'L';
            }
        } else {
            $fillCharOnTape = $parts[0];
            if ($parts[1] === 'R') {
                $tapeMovement = 'R';
            } else if ($parts[1] === 'L') {
                $tapeMovement = 'L';
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
        if ($tapeMovement === 'R') {
            $this->tape->toRight();
        } else if ($tapeMovement === 'L') {
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
            if ($part !== '' && $part !== 'R' && $part !== 'L' && $part !== 'N') {
                $res[] = "элемент должен иметь значение 'R', 'L', 'N' или быть не заданным. Сейчас задано '$part'.";
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
            if ($middle !== 'R' && $middle !== 'L' && $middle !== 'N') {
                $res[] = "средний элемент должен иметь значение 'R', 'L' или 'N'. Сейчас задано '$middle'.";
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