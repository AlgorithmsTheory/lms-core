<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;
use DB;
use App\Testing\Lecture;

class LibraryController extends Controller {
    public function index(){
        $lectures = DB::table('lectures')->select()->get();
        return view('library.index', compact('lectures'));
    }

    public function definitions(){
        return view('library.opr');
    }

    public function theorems(){
        return view('library.teoremy');
    }

    public function lecture($index, $anchor = null){
        return ($index != null) ? view('library.lectures.'.$index.$anchor) : view('library.index');
    }

    public function persons(){
        return view('library.persons.person');
    }

    public function person($name){
        return view('library.persons.'.$name);
    }

    public function extra(){
        return view('library.dop');
    }
} 