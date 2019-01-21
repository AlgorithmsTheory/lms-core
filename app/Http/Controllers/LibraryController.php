<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 08.11.15
 * Time: 2:37
 */

namespace App\Http\Controllers;
use App\Definition;
use App\Http\Requests\AddDefinitionRequest;
use App\Http\Requests\AddPersonRequest;
use App\Http\Requests\AddTheoremRequest;
use App\Http\Requests\EditPersonRequest;
use App\Http\Requests\UpdateDefinitionRequest;
use App\Http\Requests\AddLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Http\Requests\UpdateTheoremRequest;
use App\Person;
use App\Testing\Theme;
use App\Theorem;
use DB;
use App\Testing\Lecture;
use DateTime;
use Request;
use App\User;
use Auth;
use Illuminate\Filesystem\Filesystem as Filesystem;


class LibraryController extends Controller {
    public function index(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lectures = DB::table('lectures')->select()->get();
        return view('library.index', compact('lectures', 'role'));
    }

    public function definitions(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $definitions = Definition::all();
        foreach ($definitions as $definition) {
            $definition->getLinkToLectureAttribute();
        }
        return view('library.definitions.definition', compact('role' , 'definitions'));
    }

    public function theorems(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $theorems = Theorem::all();
        foreach ($theorems as $theorem) {
            $theorem->getLinkToLectureAttribute();
        }
        return view('library.theorems.theorems', compact('role', 'theorems'));
    }

    public function lecture($index, $anchor = null){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lecture = Lecture::where('lecture_number',$index)->first();
        return view('library.lectures.lecture'.$anchor, compact('lecture', 'role'));
    }

    public function persons(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $persons = Person::all();
        return view('library.persons.persons', compact('role','persons'));
    }

    public function person($id){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $person = Person::where('id',$id)->first();
        return view('library.persons.person', compact('person', 'role'));
    }

    public function extra(){
        return view('library.dop');
    }

    public function add_new_lecture(){
        return view("library.lectures.add_new_lecture");
    }

    public function store_lecture(AddLectureRequest $request){
        $lecture = new Lecture;
        $numberLecture = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $nameDocFile = "TA_lec".$numberLecture.".doc";
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
                $namePptFile = "TA_lec".$numberLecture.".ppt";
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

        $currentNumber = Lecture::where('id_section','<=',$lecture->id_section)->count();
        DB::update('UPDATE `lectures` SET `lecture_number` = `lecture_number` + 1 where `lecture_number` > ?', [$currentNumber]);

        $lecture->lecture_number = $currentNumber + 1;
        $lecture->date = new DateTime();
        $lecture->save();
        return redirect('library');
    }


    public function editLecture($id){
        $lecture = Lecture::findOrFail($id);
        return view('library.lectures.edit_lecture', compact('lecture'));
    }

    public function updateLecture(UpdateLectureRequest $request, $id){
        $lecture = Lecture::findOrFail($id);
        $lecture->lecture_name = $request->lecture_name;
        $lecture->lecture_text = $request->lecture_text;
        $numberLecture = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $nameDocFile = "TA_lec".$numberLecture.".doc";
                if (!copy($_FILES['doc_file']['tmp_name'], 'download/doc/' . $nameDocFile)){
                    return back()->withInput()->withErrors(['Ошибка при копировании doc файла']);
                }
                if (file_exists(public_path($lecture->doc_path))) {
                    app(Filesystem::class)->delete(public_path($lecture->doc_path));
                }
                $lecture->doc_path = 'download/doc/' . $nameDocFile;
            } else {
                return back()->withInput()->withErrors(['Ошибка при загрузки doc файла']);
            }
        }
        if ($request->hasFile('ppt_file')) {
            if ($request->file('ppt_file')->isValid()) {
                $namePptFile = "TA_lec".$numberLecture.".ppt";
                if (!copy($_FILES['ppt_file']['tmp_name'], 'download/ppt/' . $namePptFile)){
                    return back()->withInput()->withErrors(['Ошибка при копировании ppt файла']);
                }
                if (file_exists(public_path($lecture->ppt_path))) {
                    app(Filesystem::class)->delete(public_path($lecture->ppt_path));
                }
                $lecture->ppt_path = 'download/ppt/' . $namePptFile;
            } else {
                return back()->withInput()->withErrors(['Ошибка при загрузки ppt файла']);
            }
        }
        $lecture->save();
        return redirect('library');
    }

    public function deleteLecture($id){
        $lecture = Lecture::findOrFail($id);
        if (file_exists(public_path($lecture->doc_path))) {
            app(Filesystem::class)->delete(public_path($lecture->doc_path));
        }
        if (file_exists(public_path($lecture->ppt_path))) {
            app(Filesystem::class)->delete(public_path($lecture->ppt_path));
        }
        DB::update('UPDATE `definition` SET `idLecture` = NULL, `nameAnchor` = NULL where `idLecture` = ?', [$id]);

        DB::update('UPDATE `theorems` SET `idLecture` = NULL, `nameAnchor` = NULL where `idLecture` = ?', [$id]);

        DB::update('UPDATE `lectures` SET `lecture_number` = `lecture_number` - 1 where `lecture_number` > ?', [$lecture->lecture_number]);
        // Удаление тем из таблицы themes по id лекции
        DB::update('UPDATE `themes` SET `id_lecture` = NULL where `id_lecture` = ?', [$id]);
        $lecture->delete();
        return  $id;
    }

    public function addNewDefinition(){
        $lectures = Lecture::all();
        return view("library.definitions.add_new_definition", compact('lectures'));
    }

    public function storeDefinition(AddDefinitionRequest $request){
        $definition = new Definition();

        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $definition->idLecture = $request->id_lecture;
            $definition->nameAnchor = $request->name_anchor;
        }
        $definition->save();

        return redirect('library/definitions');
    }

    public function editDefinition($id){
        $definition = Definition::findOrFail($id);
        $lectures = Lecture::all();
        $idSectionLecture = Lecture::where('id_lecture',$definition->idLecture)->first()->id_section;
        return view("library.definitions.edit_definition", compact('lectures', 'definition', 'idSectionLecture'));
    }

    public function updateDefinition($id,UpdateDefinitionRequest $request){
        $definition = Definition::findOrFail($id);
        $definition->name = $request->definition_name;
        $definition->content = $request->definition_content;
        if ($request->id_lecture == null || $request->name_anchor == null) {
            $definition->idLecture = null;
            $definition->nameAnchor = null;
        } else {
            $definition->idLecture = $request->id_lecture;
            $definition->nameAnchor = $request->name_anchor;
        }
        $definition->save();
        return redirect('library/definitions');
    }

    public function deleteDefinition($id){
        $definition = Definition::findOrFail($id);
        $definition->delete();
        return  $id;
    }

    public function addNewTheorem(){
        $lectures = Lecture::all();
        return view("library.theorems.add_new_theorem", compact('lectures'));
    }

    public function storeTheorem(AddTheoremRequest $request){
        $theorem = new Theorem();

        $theorem->name = $request->theorem_name;
        $theorem->content = $request->theorem_content;
        $theorem->exam = $request->exam;
        $theorem->doc = $request->doc;
        if ($request->id_lecture != null && $request->name_anchor!=null) {
            $theorem->idLecture = $request->id_lecture;
            $theorem->nameAnchor = $request->name_anchor;
        }
        $theorem->save();

        return redirect('library/theorems');
    }

    public function deleteTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $theorem->delete();
        return  $id;
    }

    public function editTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $lectures = Lecture::all();
        $idSectionLecture = Lecture::where('id_lecture',$theorem->idLecture)->first()->id_section;
        return view("library.theorems.edit_theorem", compact('lectures', 'theorem', 'idSectionLecture'));
    }

    public function updateTheorem($id,UpdateTheoremRequest $request){
        $theorem = Theorem::findOrFail($id);
        $theorem->name = $request->theorem_name;
        $theorem->content = $request->theorem_content;
        $theorem->exam = $request->exam;
        $theorem->doc = $request->doc;
        if ($request->id_lecture == null || $request->name_anchor == null) {
            $theorem->idLecture = null;
            $theorem->nameAnchor = null;
        } else {
            $theorem->idLecture = $request->id_lecture;
            $theorem->nameAnchor = $request->name_anchor;
        }
        $theorem->save();
        return redirect('library/theorems');
    }

    public function addNewPerson(){
        return view("library.persons.add_new_person");
    }

    public function storePerson(AddPersonRequest $request){
        if ($request->hasFile('picture')){
            if ($request->file('picture')->isValid()){
                $name = mt_rand(0, 10000) . $request->file('picture')->getClientOriginalName();
                if (!copy($_FILES['picture']['tmp_name'], 'img/library/persons/' . $name)){
                    return back()->withInput()->withErrors(['Ошибка при копировании изображения']);
                }else{
                    $person = new Person();
                    $person->image_patch = 'img/library/persons/' . $name;
                    $person->name = $request->name_person;
                    $person->year_birth = $request->year_birth;
                    $person->year_death = $request->year_death;
                    $person->content = $request->person_text;
                    $person->save();
                }
            }else{
                return back()->withInput()->withErrors(['Ошибка при загрузке изображения']);
            }
        }
        return redirect('library/persons');
    }

    public function editPerson($id){
        $person = Person::findOrFail($id);
        return view("library.persons.edit_person", compact('person'));
    }

    public function updatePerson(EditPersonRequest $request, $id){
        $person = Person::findOrFail($id);
        $person->name = $request->name_person;
        $person->year_birth = $request->year_birth;
        $person->year_death = $request->year_death;
        $person->content = $request->person_text;
        if ($request->hasFile('picture')){
            if ($request->file('picture')->isValid()){
                $name = mt_rand(0, 10000) . $request->file('picture')->getClientOriginalName();
                if (!copy($_FILES['picture']['tmp_name'], 'img/library/persons/' . $name)){
                    return back()->withInput()->withErrors(['Ошибка при копировании изображения']);
                }else{
                    app(Filesystem::class)->delete(public_path($person->image_patch));
                    $person->image_patch = 'img/library/persons/' . $name;
                }
            }else{
                return back()->withInput()->withErrors(['Ошибка при загрузке изображения']);
            }
        }
        $person->save();
        return redirect('library/persons/'.$person->id);
    }

    public function deletePerson($id){
        $person = Person::findOrFail($id);
        if (file_exists(public_path($person->image_patch))) {
            app(Filesystem::class)->delete(public_path($person->image_patch));
        }
        $person->delete();
        return  redirect('library/persons');
    }

    public function docDownload($id) {
        $lecture = Lecture::findOrFail($id);
        return response()->download($lecture->doc_path, 'TA_lec'.$lecture->lecture_number.'.doc');
    }

    public function pptDownload($id) {
        $lecture = Lecture::findOrFail($id);
        return response()->download($lecture->ppt_path, 'TA_lec'.$lecture->lecture_number.'.ppt');
    }
} 