<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;


class RecursionController extends Controller
{
    public function index()
    {
        return view('recursion.index');
    }
}