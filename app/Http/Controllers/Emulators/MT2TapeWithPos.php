<?php


namespace App\Http\Controllers\Emulators;


use Illuminate\Support\Facades\Log;

class MT2TapeWithPos
{
    private $tape;
    private $pos;

    public function __construct($word) {
        $this->tape = new MT2Tape($word);
        $this->pos = $this->tape->getMinPos();
    }

    public function toRight() {
        $this->pos++;
    }

    public function toLeft() {
        $this->pos--;
    }

    public function getPos() {
        return $this->pos;
    }

    public function getChar() {
        return $this->tape->getChar($this->pos);
    }

    public function setChar($char) {
        $this->tape->setChar($this->pos, $char);
    }

    public function asString() {
        return $this->tape->asString();
    }

    public function getAlphabetErrors($alphabet) {
        return $this->tape->getAlphabetErrors($alphabet);
    }
}