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
use App\Http\Requests\AddEducationMaterialRequest;
use App\Http\Requests\EditEducationMaterialRequest;

use App\Library\DefinitionDAO;
use App\Library\LectureDAO;
use App\Library\PersonDAO;
use App\Library\TheoremDAO;
use App\Library\EducationalMaterialDAO;
use App\Person;
use App\Theorem;
use App\Testing\Lecture;
use App\User;
use Auth;
use  Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser as MimeType;


class LibraryController extends Controller {
    public function index(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lectures =  new LectureDAO;
        $lectures = $lectures->allLecture();
        return view('library.index', compact('lectures', 'role'));
    }

    public function definitions(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $definitions =  new DefinitionDAO();
        $definitions = $definitions->allDefinition();
        return view('library.definitions.definition', compact('role' , 'definitions'));
    }

    public function theorems(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $theorems =  new TheoremDAO();
        $theorems = $theorems->allTheorem();
        return view('library.theorems.theorems', compact('role', 'theorems'));
    }

    public function lecture($index, $anchor = null){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lecture =  new LectureDAO;
        $lecture = $lecture->getLecture($index);
        return view('library.lectures.lecture'.$anchor, compact('lecture', 'role'));
    }

    public function persons(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $persons =  new PersonDAO();
        $persons = $persons->allPerson();
        return view('library.persons.persons', compact('role','persons'));
    }

    public function person($id){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $person =  new PersonDAO();
        $person = $person->getPerson($id);
        return view('library.persons.person', compact('person', 'role'));
    }

    public function extra(){
        return view('library.dop');
    }

    public function add_new_lecture(){
        return view("library.lectures.add_new_lecture");
    }

    public function store_lecture(AddLectureRequest $request){
        $lecture =  new LectureDAO;
        $resultAction = $lecture->store_lecture($request);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library');
    }


    public function editLecture($id){
        $lecture = Lecture::findOrFail($id);
        return view('library.lectures.edit_lecture', compact('lecture'));
    }

    public function updateLecture(UpdateLectureRequest $request, $id){
        $lecture =  new LectureDAO;
        $resultAction = $lecture->updateLecture($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library');
    }

    public function deleteLecture($id){
        $lecture =  new LectureDAO;
        $resultAction = $lecture->deleteLecture($id);
        return  json_encode(array("msg" => $resultAction));
    }

    public function addNewDefinition(){
        $lectures = Lecture::all();
        return view("library.definitions.add_new_definition", compact('lectures'));
    }

    public function storeDefinition(AddDefinitionRequest $request){
        $definitions =  new DefinitionDAO();
        $definitions->store_Definition($request);
        return redirect('library/definitions');
    }

    public function editDefinition($id){
        $definition = Definition::findOrFail($id);
        $idSectionLecture = Lecture::where('id_lecture',$definition->idLecture)->first()->id_section;
        $lectures = Lecture::all();
        return view("library.definitions.edit_definition", compact('lectures', 'definition', 'idSectionLecture'));
    }

    public function updateDefinition($id,UpdateDefinitionRequest $request){
        $definitions =  new DefinitionDAO();
        $definitions->updateDefinition($request, $id);
        return redirect('library/definitions');
    }

    public function deleteDefinition($id){
        $definitions =  new DefinitionDAO();
        $definitions->deleteDefinition($id);
        return  $id;
    }

    public function addNewTheorem(){
        $lectures = Lecture::all();
        return view("library.theorems.add_new_theorem", compact('lectures'));
    }

    public function storeTheorem(AddTheoremRequest $request){
        $theorems =  new TheoremDAO();
        $theorems->store_Theorem($request);
        return redirect('library/theorems');
    }

    public function deleteTheorem($id){
        $theorems =  new TheoremDAO();
        $theorems->deleteTheorem($id);
        return  $id;
    }

    public function editTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $lectures = Lecture::all();
        $idSectionLecture = Lecture::where('id_lecture',$theorem->idLecture)->first()->id_section;
        return view("library.theorems.edit_theorem", compact('lectures', 'theorem', 'idSectionLecture'));
    }

    public function updateTheorem($id,UpdateTheoremRequest $request){
        $theorems =  new TheoremDAO();
        $theorems->updateTheorem($request, $id);
        return redirect('library/theorems');
    }

    public function addNewPerson(){
        return view("library.persons.add_new_person");
    }

    public function storePerson(AddPersonRequest $request){
        $persons =  new PersonDAO();
        $resultAction = $persons->store_Person($request);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/persons');
    }

    public function editPerson($id){
        $person = Person::findOrFail($id);
        return view("library.persons.edit_person", compact('person'));
    }

    public function updatePerson(EditPersonRequest $request, $id){
        $persons = new PersonDAO();
        $resultAction = $persons->updatePerson($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/persons/'.$persons->getPerson($id)->id);
    }

    public function deletePerson($id){
        $persons = new PersonDAO();
        $persons->deletePerson($id);
        return  redirect('library/persons');
    }

    public function docDownload($id) {
        $lecture = Lecture::findOrFail($id);
        $file = new File($lecture->doc_path);
        $mimetypes = new MimeType;
        $returnName = 'TA_lec'.$lecture->lecture_number;
        switch ($mimetypes->guess($file->getMimeType())) {
            case "doc":
                $returnName = $returnName.".doc";
                break;
            case "docx":
                $returnName = $returnName.".docx";
                break;
        }
        return response()->download($lecture->doc_path, $returnName);
    }

    public function pptDownload($id) {
        $lecture = Lecture::findOrFail($id);
        $file = new File($lecture->ppt_path);
        $mimetypes = new MimeType;
        $returnName = 'TA_lec'.$lecture->lecture_number;
        switch ($mimetypes->guess($file->getMimeType())) {
            case "ppt":
                $returnName = $returnName.".ppt";
                break;
            case "pptx":
                $returnName = $returnName.".pptx";
                break;
        }
        return response()->download($lecture->ppt_path, $returnName);
    }

    public function educationalMaterials() {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $educationalMaterials =  new EducationalMaterialDAO();
        $educationalMaterials = $educationalMaterials->allEducationalMaterial();
        return view('library.educational_materials.educational_materials', compact('role' , 'educationalMaterials'));
    }

    public function addEducationalMaterial(){
        return view("library.educational_materials.add_educational_material");
    }

    public function storeEducationalMaterial(AddEducationMaterialRequest $request){
        $ducationalMaterial =  new EducationalMaterialDAO();
        $resultAction = $ducationalMaterial->storeEducationalMaterial($request);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/educationalMaterials');
    }

    public function educationalMaterialsDownload($id){
        $educationalMaterial =  new EducationalMaterialDAO();
        $educationalMaterial = $educationalMaterial->getEducationalMaterial($id);
        $returnName = str_replace(' ', '_', $educationalMaterial->name);
        $file = new File($educationalMaterial->file_path);
        $mimetypes = new MimeType;
        switch ($mimetypes->guess($file->getMimeType())) {
            case "doc":
                $returnName = $returnName.".doc";
                break;
            case "docx":
                $returnName = $returnName.".docx";
                break;
            case "pdf":
                $returnName = $returnName.".pdf";
                break;
        }
        return response()->download($educationalMaterial->file_path, $returnName);
    }


    public function editEducationalMaterial($id){
        $educationalMaterial =  new EducationalMaterialDAO();
        $educationalMaterial = $educationalMaterial->getEducationalMaterial($id);
        return view('library.educational_materials.edit_educational_material', compact('educationalMaterial'));
    }

    public function updateEducationalMaterial(EditEducationMaterialRequest $request, $id){
        $educationalMaterial =  new EducationalMaterialDAO();
        $resultAction = $educationalMaterial->updateEducationalMaterial($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/educationalMaterials');
    }

    public function deleteEducationalMaterial($id){
        $educationalMaterial =  new EducationalMaterialDAO();
        $resultAction = $educationalMaterial->deleteEducationalMaterial($id);
        return  json_encode(array("msg" => $resultAction, "id" => $id));
    }
}