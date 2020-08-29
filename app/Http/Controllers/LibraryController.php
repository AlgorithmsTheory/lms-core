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

use App\Library\DAO\EbookDAO;
use App\Library\DAO\ExtraDAO;
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
use Illuminate\Http\Request;
use  Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser as MimeType;


class LibraryController extends Controller {

    private $personDao;
    private $lectureDao;
    private $definitionDao;
    private $theoremDao;
    private $educationalMaterialDao;
    private $extra_DAO;
    private $ebook_DAO;

    function __construct(PersonDAO $personDao, LectureDAO $lectureDao, DefinitionDAO $definitionDao, TheoremDAO $theoremDao,
                         EducationalMaterialDAO $educationalMaterialDAO, ExtraDAO $extra_DAO, EbookDAO $ebook_DAO) {
        $this->personDao = $personDao;
        $this->lectureDao = $lectureDao;
        $this->definitionDao = $definitionDao;
        $this->theoremDao = $theoremDao;
        $this->educationalMaterialDao = $educationalMaterialDAO;
        $this->extra_DAO = $extra_DAO;
        $this->ebook_DAO = $ebook_DAO;
    }

    public function index(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lectures = $this->lectureDao->allLecture();
        return view('library.index', compact('lectures', 'role'));
    }

    public function definitions(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $definitions = $this->definitionDao->allDefinition();
        return view('library.definitions.definition', compact('role' , 'definitions'));
    }

    public function theorems(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $theorems = $this->theoremDao->allTheorem();
        return view('library.theorems.theorems', compact('role', 'theorems'));
    }

    public function lecture($index, $anchor = null){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $lecture = $this->lectureDao->getLecture($index);
        return view('library.lectures.lecture'.$anchor, compact('lecture', 'role'));
    }

    public function persons(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $persons = $this->personDao->allPerson();
        return view('library.persons.persons', compact('role','persons'));
    }

    public function person($id){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $person = $this->personDao->getPerson($id);
        return view('library.persons.person', compact('person', 'role'));
    }

    public function extras(){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $extras = $this->extra_DAO->allExtras();
        $dir_parent_module = ExtraDAO::DIR_PARENT_MODULE ;
        return view('library.extras.extras', compact('extras','role', 'dir_parent_module'));
    }

    public function extraStore(Request $request) {
        $validator = $this->extra_DAO->validate($request);
        if ($validator->passes()) {
            $this->extra_DAO->storeExtra($request);
            return redirect('library/extras');
        } else {
            return back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function extraEdit($id_extra) {
        $extra = $this->extra_DAO->getExtra($id_extra);
        return view('library.extras.edit_extra', compact('extra'));
    }

    public function extraUpdate(Request $request, $id_extra) {
        $validator = $this->extra_DAO->validate($request);
        if ($validator->passes()) {
            $this->extra_DAO->updateExtra($request, $id_extra);
            return redirect('library/extras');
        } else {
            return back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function extraDelete($id_extra) {
        $this->extra_DAO->deleteExtra($id_extra);
        return 0;
    }

    public function addNewLecture(){
        return view("library.lectures.add_new_lecture");
    }

    public function storeLecture(AddLectureRequest $request){
        $resultAction = $this->lectureDao->storeLecture($request);
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
        $resultAction = $this->lectureDao->updateLecture($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library');
    }

    public function deleteLecture($id){
        $resultAction = $this->lectureDao->deleteLecture($id);
        return  json_encode(array("msg" => $resultAction));
    }

    public function addNewDefinition(){
        $lectures = Lecture::all();
        return view("library.definitions.add_new_definition", compact('lectures'));
    }

    public function storeDefinition(AddDefinitionRequest $request){
        $this->definitionDao->storeDefinition($request);
        return redirect('library/definitions');
    }

    public function editDefinition($id){
        $definition = Definition::findOrFail($id);
        $idSectionLecture = Lecture::where('id_lecture',$definition->id_lecture)->first()->id_section;
        $lectures = Lecture::all();
        return view("library.definitions.edit_definition", compact('lectures', 'definition', 'idSectionLecture'));
    }

    public function updateDefinition($id,UpdateDefinitionRequest $request){
        $this->definitionDao->updateDefinition($request, $id);
        return redirect('library/definitions');
    }

    public function deleteDefinition($id){
        $this->definitionDao->deleteDefinition($id);
        return  $id;
    }

    public function addNewTheorem(){
        $lectures = Lecture::all();
        return view("library.theorems.add_new_theorem", compact('lectures'));
    }

    public function storeTheorem(AddTheoremRequest $request){
        $this->theoremDao->storeTheorem($request);
        return redirect('library/theorems');
    }

    public function deleteTheorem($id){
        $this->theoremDao->deleteTheorem($id);
        return  $id;
    }

    public function editTheorem($id){
        $theorem = Theorem::findOrFail($id);
        $lectures = Lecture::all();
        $idSectionLecture = Lecture::where('id_lecture',$theorem->id_lecture)->first()->id_section;
        return view("library.theorems.edit_theorem", compact('lectures', 'theorem', 'idSectionLecture'));
    }

    public function updateTheorem($id,UpdateTheoremRequest $request){
        $this->theoremDao->updateTheorem($request, $id);
        return redirect('library/theorems');
    }

    public function addNewPerson(){
        return view("library.persons.add_new_person");
    }

    public function storePerson(AddPersonRequest $request){
        $resultAction = $this->personDao->store_Person($request);
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
        $resultAction = $this->personDao->updatePerson($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/persons/'.$this->personDao->getPerson($id)->id);
    }

    public function deletePerson($id){
        $this->personDao->deletePerson($id);
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
        $educationalMaterials = $this->educationalMaterialDao->allEducationalMaterial();
        return view('library.educational_materials.educational_materials', compact('role' , 'educationalMaterials'));
    }

    public function addEducationalMaterial(){
        return view("library.educational_materials.add_educational_material");
    }

    public function storeEducationalMaterial(AddEducationMaterialRequest $request){
        $resultAction = $this->educationalMaterialDao->storeEducationalMaterial($request);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/educationalMaterials');
    }

    public function educationalMaterialsDownload($id){
        $educationalMaterial = $this->educationalMaterialDao->getEducationalMaterial($id);
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
        $educationalMaterial = $this->educationalMaterialDao->getEducationalMaterial($id);
        return view('library.educational_materials.edit_educational_material', compact('educationalMaterial'));
    }

    public function updateEducationalMaterial(EditEducationMaterialRequest $request, $id){
        $resultAction = $this->educationalMaterialDao->updateEducationalMaterial($request, $id);
        if ($resultAction != 'ok') {
            return back()->exceptInput()->withErrors([$resultAction]);
        }
        return redirect('library/educationalMaterials');
    }

    public function deleteEducationalMaterial($id){
        $resultAction = $this->educationalMaterialDao->deleteEducationalMaterial($id);
        return  json_encode(array("msg" => $resultAction, "id" => $id));
    }

    public function ebooks() {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $ebooks_groupBy_genre = $this->ebook_DAO->allEbooksGroupByGenre();
        $search_query = "";
        $dir_parent_module = EbookDAO::DIR_PARENT_MODULE ;
        return view("library.ebooks.ebooks", compact('ebooks_groupBy_genre',
            'search_query', 'role', 'dir_parent_module'));
    }

    public function searchEbooks(Request $request){
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $search_query = $request->input('search');
        $ebooks_groupBy_genre = $this->ebook_DAO->searchEbooks($search_query);
        $dir_parent_module = EbookDAO::DIR_PARENT_MODULE ;
        return view("library.ebooks.ebooks", compact('ebooks_groupBy_genre','search_query', 'role', 'dir_parent_module'));
    }

    public function addEbook() {
        return view('library.ebooks.add_ebook');
    }

    public function storeEbook(Request $request) {
        $validator = $this->ebook_DAO->validateStore($request);
        if ($validator->passes()) {
            $id_ebook = $this->ebook_DAO->storeEbook($request);
            return redirect()->route('get_ebook', ['id_ebook' => $id_ebook]);
        } else {
            return back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function getEbook($id_ebook) {
        $role = User::whereId(Auth::user()['id'])->select('role')->first()->role;
        $ebook = $this->ebook_DAO->getEbook($id_ebook);
        $dir_parent_module = EbookDAO::DIR_PARENT_MODULE ;
        return view('library.ebooks.ebook', compact('ebook', 'role', 'dir_parent_module'));
    }

    public function editEbook($id_ebook) {
        $ebook = $this->ebook_DAO->getEbook($id_ebook);
        return view('library.ebooks.edit_ebook', compact('ebook'));
    }

    public function updateEbook(Request $request, $id_ebook) {
        $validator = $this->ebook_DAO->validateUpdate($request);
        if ($validator->passes()) {
            $this->ebook_DAO->updateEbook($request, $id_ebook);
            return redirect()->route('get_ebook', ['id_ebook' => $id_ebook]);
        } else {
            return back()->withInput($request->all())->withErrors($validator);
        }
    }

    public function deleteEbook($id_ebook) {
        $this->ebook_DAO->deleteEbook($id_ebook);
        return redirect()->route('ebooks');
    }
}