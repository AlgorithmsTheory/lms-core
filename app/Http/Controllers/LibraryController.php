<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;
use App\Http\Requests\AddLectureRequest;
use DB;
use App\Testing\Lecture;
use Request;
use App\User;
use Auth;



class LibraryController extends Controller {
    public function index(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lectures = DB::table('lectures')->select()->get();
        return view('library.index', compact('lectures', 'role'));
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

    public function add_new_lecture(){
        return view("library.lectures.add_new_lecture");
    }

    public function store_lecture(AddLectureRequest $request){
        $lecture = new Lecture;
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $nameDocFile = "TA_lec".mt_rand(0, 10000).".doc";
                $lecture->doc_path = 'download/doc/' . $nameDocFile;
                if (!copy($_FILES['doc_file']['tmp_name'], 'download/doc/' . $nameDocFile)){
                    return back()->withInput()->withErrors(['Ошибка при копировании doc файла']);
                }
            } else {
                return back()->withInput()->withErrors(['Ошибка при загрузки doc файла']);
            }
        }
        if ($request->hasFile('ppt_file')) {
            if ($request->file('ppt_file')->isValid()) {
                $namePptFile = "TA_lec".mt_rand(0, 10000).".ppt";
                $lecture->ppt_path = 'download/ppt/' . $namePptFile;
                if (!copy($_FILES['ppt_file']['tmp_name'], 'download/ppt/' . $namePptFile)){
                    return back()->withInput()->withErrors(['Ошибка при копировании ppt файла']);
                }
            } else {
                return back()->withInput()->withErrors(['Ошибка при загрузки ppt файла']);
            }
        }
                    $lecture->lecture_name = $request->lecture_name;
                    $lecture->lecture_text = $request->lecture_text;
                    $lecture->id_section = $request->id_section;
                    $lecture->save();
        return redirect('library');
    }

    public function getLecture($index, $number){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lecture = DB::table('lectures')->where('id_lecture', '=', "$index")
            ->select('lectures.id_lecture', 'lectures.lecture_name', 'lectures.lecture_text')->first();
        return view("library.lectures.lecture", compact('lecture', 'role', 'number'));
    }
} 