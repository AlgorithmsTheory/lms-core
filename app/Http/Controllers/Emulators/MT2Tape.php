<?php

namespace App\Http\Controllers\Emulators;

use App\Utils\StringUtils;
use Illuminate\Support\Facades\Log;

/**
 * MT2Tape represents infinite tape of the Turing Machine.
 *
 * @author Michail Safronov
 */
class MT2Tape
{
    /**
     * $buffer is an associative array int => str
     * where integer key is the position of the character on tape
     * and the string value is the character itself.
     * If no character is set on the position (e.g. lambdaSymbol), then
     * the key does not exist.
     *
     * @var array
     */
    private $buffer;

    /**
     * The symbol meaning nothing on the tape.
     *
     * @var string
     */
    private $lambdaSymbol;

    /**
     *
     * @param string $word A string from which the tape should be created.
     */
    public function __construct($word) {
        $this->lambdaSymbol = 'λ';
        $this->buffer = $this->toTapePresentation($word);
    }

    public function getInternalBuffer() {
        return $this->buffer;
    }

    /**
     * getChar() returns the character which is set on the $pos position on the tape
     * or $lambdaSymbol if the character does not exist on the specified position.
     *
     * @param number $pos
     * @return string
     */
    public function getChar($pos) {
        if (array_key_exists($pos, $this->buffer)) {
            return $this->buffer[$pos];
        }
        return $this->lambdaSymbol;
    }

    /**
     * setChar() place the $char character on the tape.
     * use $lambdaSymbol as $char-value if you need to clear the character
     * on the specified position on the tape.
     *
     * @param number $pos
     * @param string $char
     * @return void
     */
    public function setChar($pos, $char) {
        if ($char === $this->lambdaSymbol) {
            unset($this->buffer[$pos]);
        } else {
            $this->buffer[$pos] = $char;
        }
    }

    private function isClear() {
        return count($this->buffer) === 0;
    }

    public function getMinPos() {
        if ($this->isClear()) {
            return 0;
        }
        $res = PHP_INT_MAX;
        foreach ($this->buffer as $key => $char) {
            if ($key < $res) {
                $res = $key;
            }
        }
        return $res;
    }

    public function getMaxPos() {
        if ($this->isClear()) {
            return -1;
        }
        $res = PHP_INT_MIN;
        foreach ($this->buffer as $key => $char) {
            if ($key > $res) {
                $res = $key;
            }
        }
        return $res;
    }

    public function asString() {
        if ($this->isClear()) {
            return '';
        }
        $minPos = $this->getMinPos();
        $maxPos = $this->getMaxPos();
        $result = '';
        for ($key = $minPos; $key <= $maxPos; $key++) {
            $result .= $this->getChar($key);
        }
        return $result;
    }

    private function toTapePresentation($word) {
        $tape = StringUtils::utf8_split($word);
        $keysToRemove = [];
        foreach ($tape as $ind => $symbol) {
            if ($symbol === $this->lambdaSymbol) {
                array_push($keysToRemove, $ind);
            }
        }
        foreach ($keysToRemove as $key) {
            unset($tape[$key]);
        }
        return $tape;
    }

    public function getAlphabetErrors($alphabet) {
        $res = [];
        foreach ($this->buffer as $symbol) {
            if (!in_array($symbol, $alphabet, true)) {
                $alphabetStr = join('', $alphabet);
                $res[] = "На ленте имеется символ '$symbol', который не входит в состав алфавита \"$alphabetStr\".";
            }
        }
        return $res;
    }
}