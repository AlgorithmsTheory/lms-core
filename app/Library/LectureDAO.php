<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;


use App\Definition;
use App\Http\Requests\AddLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Testing\Lecture;
use App\Testing\Theme;
use App\Theorem;
use DateTime;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser as MimeType;
class LectureDAO {

    public function allLecture(){
        return Lecture::all();
    }

    public function getLecture($index){
        return Lecture::where('lecture_number',$index)->first();
    }

    public function storeLecture(AddLectureRequest $request){
        $lecture = new Lecture;
        $rundomNumber = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $mimetypes = new MimeType;
                $nameDocFile = "TA_lec".$rundomNumber;
                switch ($mimetypes->guess($request->file('doc_file')->getMimeType())) {
                    case "doc":
                        $nameDocFile = $nameDocFile.".doc";
                        break;
                    case "docx":
                        $nameDocFile = $nameDocFile.".docx";
                        break;
                }
                $lecture->doc_path = 'download/doc/' . $nameDocFile;
                if (!copy($_FILES['doc_file']['tmp_name'], 'download/doc/' . $nameDocFile)){
                    return 'Ошибка при копировании doc файла';
                }
            } else {
                return 'Ошибка при загрузки doc файла';
            }
        }
        if ($request->hasFile('ppt_file')) {
            if ($request->file('ppt_file')->isValid()) {
                $mimetypes = new MimeType;
                $namePptFile = "TA_lec".$rundomNumber;
                switch ($mimetypes->guess($request->file('ppt_file')->getMimeType())) {
                    case "ppt":
                        $namePptFile = $namePptFile.".ppt";
                        break;
                    case "pptx":
                        $namePptFile = $namePptFile.".pptx";
                        break;
                }
                $lecture->ppt_path = 'download/ppt/' . $namePptFile;
                if (!copy($_FILES['ppt_file']['tmp_name'], 'download/ppt/' . $namePptFile)){
                    return 'Ошибка при копировании ppt файла';
                }
            } else {
                return 'Ошибка при загрузки ppt файла';
            }
        }
        $lecture->lecture_name = $request->lecture_name;
        $lecture->lecture_text = $request->lecture_text;
        $lecture->id_section = $request->id_section;

        $currentNumber = Lecture::where('id_section','<=',$lecture->id_section)->count();

        Lecture::where('lecture_number', '>', $currentNumber)->increment('lecture_number');

        $lecture->lecture_number = $currentNumber + 1;
        $lecture->date = new DateTime();
        $lecture->save();
        return 'ok';
    }

    public function updateLecture(UpdateLectureRequest $request, $id){
        $lecture = Lecture::findOrFail($id);
        $lecture->lecture_name = $request->lecture_name;
        $lecture->lecture_text = $request->lecture_text;
        $rundomNumber = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $mimetypes = new MimeType;
                $nameDocFile = "TA_lec".$rundomNumber;
                switch ($mimetypes->guess($request->file('doc_file')->getMimeType())) {
                    case "doc":
                        $nameDocFile = $nameDocFile.".doc";
                        break;
                    case "docx":
                        $nameDocFile = $nameDocFile.".docx";
                        break;
                }
                if (!copy($_FILES['doc_file']['tmp_name'], 'download/doc/' . $nameDocFile)){
                    return 'Ошибка при копировании doc файла';
                }
                if (file_exists(public_path($lecture->doc_path))) {
                    app(Filesystem::class)->delete(public_path($lecture->doc_path));
                }
                $lecture->doc_path = 'download/doc/' . $nameDocFile;
            } else {
                return 'Ошибка при загрузки doc файла';
            }
        }
        if ($request->hasFile('ppt_file')) {
            if ($request->file('ppt_file')->isValid()) {
                $mimetypes = new MimeType;
                $namePptFile = "TA_lec".$rundomNumber;
                switch ($mimetypes->guess($request->file('ppt_file')->getMimeType())) {
                    case "ppt":
                        $namePptFile = $namePptFile.".ppt";
                        break;
                    case "pptx":
                        $namePptFile = $namePptFile.".pptx";
                        break;
                }
                if (!copy($_FILES['ppt_file']['tmp_name'], 'download/ppt/' . $namePptFile)){
                    return 'Ошибка при копировании ppt файла';
                }
                if (file_exists(public_path($lecture->ppt_path))) {
                    app(Filesystem::class)->delete(public_path($lecture->ppt_path));
                }
                $lecture->ppt_path = 'download/ppt/' . $namePptFile;
            } else {
                return 'Ошибка при загрузки ppt файла';
            }
        }
       $lecture->save();
        return 'ok';
    }

    public function deleteLecture($id){
        $lecture = Lecture::findOrFail($id);
        if ($lecture->doc_path != null && file_exists(public_path($lecture->doc_path))) {
           if (!app(Filesystem::class)->delete(public_path($lecture->doc_path))) {
               return 'Ошибка удаления doc файла';
           }
        }
        if ($lecture->ppt_path != null && file_exists(public_path($lecture->ppt_path))) {
            if (!app(Filesystem::class)->delete(public_path($lecture->ppt_path))) {
                return 'Ошибка удаления ppt файла';
            }
        }

        Definition::where('id_lecture', '=', $id)->update(['id_lecture' => null,
                                                                            'name_anchor' => null]);
        Theorem::where('id_lecture', '=', $id)->update(['id_lecture' => null,
                                                                            'name_anchor' => null]);

        Lecture::where('lecture_number', '>', $lecture->lecture_number)->decrement('lecture_number');

        // Удаление тем из таблицы themes по id лекции
        Theme::where('id_lecture', '=', $id)->update(['id_lecture' => null]);
        $lecture->delete();
        return 'ok';
    }
}