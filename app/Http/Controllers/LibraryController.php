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

    public function lecture($index){
        return view('library.lectures.'.$index);
    }
} 