<?php

namespace App\Http\Controllers\Emulators;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\MtFees;

class MT2Controller extends Controller {

    public function openMT() {
        $fees = MtFees::first();
        return view("algorithm.mt2", compact('fees'));
    }

    public function openMT2Help() {
        $fees = MtFees::first();
        return view("algorithm.mt2help", compact('fees'));
    }
}