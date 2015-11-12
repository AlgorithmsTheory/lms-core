<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;


class LibraryController extends Controller {
    public function index(){
        return view('library.index');
    }

    public function definitions(){
        return view('library.opr');
    }

    public function theorems(){
        return view('library.teoremy');
    }

    public function lecture($index){
        return view('library.lectures.'.$index);
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