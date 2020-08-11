<?php

namespace App\Http\Controllers\Emulators;
use App\Http\Controllers\Controller;

class RamEmulatorController extends Controller {

	public function openRAM() {
        return view('algorithm.RAM');
	}

}
