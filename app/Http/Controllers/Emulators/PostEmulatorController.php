<?php

namespace App\Http\Controllers\Emulators;
use App\Http\Controllers\Controller;

class PostEmulatorController extends Controller {
	public function openPost() {
		return view("algorithm.Post");
	}
}
