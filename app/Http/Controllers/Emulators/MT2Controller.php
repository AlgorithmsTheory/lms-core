<?php

namespace App\Http\Controllers\Emulators;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class MT2Controller extends Controller {

    public function openMT() {
        return view("algorithm.mt2");
    }

    public function openMT2Help() {
        return view("algorithm.mt2help");
    }

//    public function mt2_try() {
//        $lambdaSymbol = 'λ';
//        $inputWord = "1011ф{$lambdaSymbol}some{$lambdaSymbol}other{$lambdaSymbol}";
//        $tape = new MT2TapeWithPos($inputWord);
//        Log::debug($tape->asString());
//        return view("algorithm.mt2");
//    }
}