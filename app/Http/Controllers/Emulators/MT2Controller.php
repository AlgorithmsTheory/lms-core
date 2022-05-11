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
}