<?php


namespace App\Http\Controllers\Emulators;


use App\Utils\StringUtils;
use Illuminate\Support\Facades\Log;

class HAM2Machine
{
    private $list;
    private $alphabet;
    private $lambdaSymbol;
    private $lastCommandSymbol;
    private $currentWord;
    private $removingSymbol;

    public function __construct($list, $alphabet) {
        $this->lambdaSymbol = 'Λ';
        $this->lastCommandSymbol = '•';
        $this->removingSymbol = '_';
        $this->list = $list;
        $this->alphabet = $alphabet;
        $this->currentWord = '';
    }

    public function run($input) {
        $this->currentWord = $input;
        $itersCount = $this->runInternal();
        $output = $this->currentWord;
        return [
            'cycle' => $itersCount,
            'result' => $output,
        ];
    }

    private function runInternal() {
        $errors = $this->getErrors();
        if (count($errors) > 0) {
            return 0;
        }
        $itersCount = 500;
        $stopReason = 'too-many-commands';
        for ($i = 0; $i < $itersCount; $i++) {
            $isLast = $this->makeStep();
            if ($isLast) {
                $stopReason = 'successful-finish';
                $itersCount = $i + 1;
                break;
            }
        }
        if ($stopReason == 'too-many-commands') {
            $errors[] = "Машина была остановлена, т.к. за $itersCount команд не было найдено последней команды.";
        }
        return $itersCount;
    }

    private function makeStep() {
        foreach ($this->list as $row) {
            $source = $row['source'];
            $dest = $row['dest'];
            if ($source === '') {
                continue;
            }
            $sourceIsLambda = true;
            $chars = mb_str_split($source);
            foreach ($chars as $symb) {
                if ($symb !== $this->lambdaSymbol) {
                    $sourceIsLambda = false;
                }
            }
            $source = StringUtils::mb_replace($source, $this->lambdaSymbol, '');
            if (!$sourceIsLambda && !StringUtils::mb_includes($this->currentWord, $source)) {
                continue;
            }
            $isLastCommand = StringUtils::mb_includes($dest, $this->lastCommandSymbol);
            $isRemovingRule = StringUtils::mb_includes($dest, $this->removingSymbol);
            if ($isRemovingRule) {
                $dest = '';
            } else {
                $dest = StringUtils::mb_replace($dest, $this->lastCommandSymbol, '');
                $dest = StringUtils::mb_replace($dest, $this->lambdaSymbol, '');
            }
            if ($sourceIsLambda) {
                $this->currentWord = $dest . $this->currentWord;
            } else {
                $this->currentWord = StringUtils::mb_replace_first($this->currentWord, $source, $dest);
            }
            return $isLastCommand;
        }
        return true;
    }

    private function getErrors() {
        $res = [];
        foreach ($this->list as $i => $row) {
            $num = $i + 1;
            $source = mb_str_split($row['source']);
            foreach ($source as $letter) {
                if (!in_array($letter, $this->alphabet) && $letter !== $this->lambdaSymbol) {
                    $res[] = "Правило №$num (левая часть) содержит символ не из алфавита: $letter";
                }
            }
            $dest = mb_str_split($row['dest']);
            foreach ($dest as $letter) {
                if (!in_array($letter, $this->alphabet) && $letter !== $this->lambdaSymbol && $letter !== $this->lastCommandSymbol
                    && $letter !== $this->removingSymbol) {
                    $res[] = "Правило №$num (правая часть) содержит символ не из алфавита: $letter";
                }
            }
        }
        return $res;
    }
}