<?php

namespace App\Http\Controllers\Emulators;
use Auth;
use Request;
use App\User;
use App\Emulators\UserResultRam;
use App\Emulators\KontrWork;
use App\Emulators\EmrForGroup;
use App\Emulators\TasksRam;
use App\Emulators\TestsequenceRam;
use App\Http\Controllers\Controller;

class RamEmulatorController extends Controller {

	public function openRAM() {
        return view('algorithm.RAM');
	}

}
