<?php

namespace App\Http\Controllers\Emulators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\HamFees;

class HAMController extends Controller {
    public function openHAM() {
        $fees = HamFees::first();
        return view("algorithm.ham2", compact('fees'));
    }

    public function openHAM2_HELP() {
        return view("algorithm.ham2_HELP");
    }

    public function openHAM2_SCORES() {
        $fees = HamFees::first();
        return view("algorithm.ham2_SCORES", compact('fees'));
    }

    public function openHAMHelp() {
        $fees = HamFees::first();
        return view("algorithm.HAMhelp", compact('fees'));
    }

    public function show_edit_params_ham() {
        $fees = HamFees::first();
        return view("algorithm.hamedit_params", compact('fees'));
    }

    public function edit_params_ham(Request $request) {
        $debugPercent = $request->input('debugPercent');
        $runPercent = $request->input('runPercent');
        $checkSyntaxPercent = $request->input('checkSyntaxPercent');
        $fees = HamFees::first();
        $fees->debug_fee = $debugPercent;
        $fees->run_fee = $runPercent;
        $fees->check_syntax_fee = $checkSyntaxPercent;
        $fees->save();
        return [
            'success' => true,
        ];
    }
}