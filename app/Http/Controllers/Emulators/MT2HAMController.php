<?php

namespace App\Http\Controllers\Emulators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\MtFees;
use App\HamFees;

class MT2HAMController extends Controller {

    public function openMT() {
        $fees = MtFees::first();
        return view("algorithm.mt2", compact('fees'));
    }

    public function openHAM() {
        $fees = HamFees::first();
        return view("algorithm.ham2", compact('fees'));
    }

    public function openMT2Help() {
        $fees = MtFees::first();
        return view("algorithm.mt2help", compact('fees'));
    }

    public function openMT2HelpAlternative() {
        $fees = MtFees::first();
        return view("algorithm.mt2_emulator_help", compact('fees'));
    }

    public function openMT2_HELP() {
        return view("algorithm.mt2_HELP");
    }

    public function openMT2_SCORES() {
        $fees = MtFees::first();
        return view("algorithm.mt2_SCORES", compact('fees'));
    }

    public function openHAMHelp() {
        $fees = HamFees::first();
        return view("algorithm.HAMhelp", compact('fees'));
    }

    public function show_edit_params_mt2() {
        $fees = MtFees::first();
        return view("algorithm.mt2edit_params", compact('fees'));
    }

    public function show_edit_params_ham() {
        $fees = HamFees::first();
        return view("algorithm.hamedit_params", compact('fees'));
    }

    public function edit_params_mt2(Request $request) {
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

    public function edit_params_ham(Request $request) {
        $debugPercent = $request->input('debugPercent');
        $runPercent = $request->input('runPercent');
        $stepsPercent = $request->input('stepsPercent');
        $fees = HamFees::first();
        $fees->debug_fee = $debugPercent;
        $fees->run_fee = $runPercent;
        $fees->steps_fee = $stepsPercent;
        $fees->save();
        return [
            'success' => true,
        ];
    }
}