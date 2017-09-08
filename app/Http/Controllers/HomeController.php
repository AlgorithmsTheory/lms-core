<?php namespace App\Http\Controllers;

use App\Group;
use App\News;
use Auth;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	public function get_home()
	{
		if(Auth::check()) {
			$news = News::where('is_visible', 1)->get();
			return view('main', compact('news'));
		}
		else {
			$groups = Group::where('archived', 0)->get();
			return view('welcome', compact('groups'));
		}
	}

}
