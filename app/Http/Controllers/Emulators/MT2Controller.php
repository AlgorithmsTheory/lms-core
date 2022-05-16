<?php

namespace App\Http\Controllers\Emulators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function show_edit_params() {
        $fees = MtFees::first();
        return view("algorithm.mt2edit_params", compact('fees'));
    }

    public function edit_params(Request $request) {
        $debugPercent = $request->input('debugPercent');
        $checkSyntaxPercent = $request->input('checkSyntaxPercent');
        $runPercent = $request->input('runPercent');
        $fees = MtFees::first();
        $fees->debug_fee = $debugPercent;
        $fees->check_syntax_fee = $checkSyntaxPercent;
        $fees->run_fee = $runPercent;
        $fees->save();
        return [
            'success' => true,
        ];
    }
}