<?php
/**
 * Created by PhpStorm.
 * User: ishun
 * Date: 22.01.2019
 * Time: 16:28
 */

namespace App\Library;


use App\Http\Requests\AddLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Testing\Lecture;
use DateTime;
use Illuminate\Filesystem\Filesystem;
use DB;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeExtensionGuesser as MimeType;
class LectureDAO
{
    public function allLecture(){
        return Lecture::all();
    }

    public function getLecture($index){
        return Lecture::where('lecture_number',$index)->first();
    }

    public function store_lecture(AddLectureRequest $request){
        $lecture = new Lecture;
        $numberLecture = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $mimetypes = new MimeType;
                $nameDocFile = "TA_lec".$numberLecture;
                switch ($mimetypes->guess($request->file('doc_file')->getMimeType())) {
                    case "doc":
                        $nameDocFile = mt_rand(0, 10000) . $nameDocFile.".doc";
                        break;
                    case "docx":
                        $nameDocFile = mt_rand(0, 10000) . $nameDocFile.".docx";
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
                $namePptFile = "TA_lec".$numberLecture;
                switch ($mimetypes->guess($request->file('ppt_file')->getMimeType())) {
                    case "ppt":
                        $namePptFile = mt_rand(0, 10000) . $namePptFile.".ppt";
                        break;
                    case "pptx":
                        $namePptFile = mt_rand(0, 10000) . $namePptFile.".pptx";
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
        DB::update('UPDATE `lectures` SET `lecture_number` = `lecture_number` + 1 where `lecture_number` > ?', [$currentNumber]);

        $lecture->lecture_number = $currentNumber + 1;
        $lecture->date = new DateTime();
        $lecture->save();
        return 'ok';
    }

    public function updateLecture(UpdateLectureRequest $request, $id){
        $lecture = Lecture::findOrFail($id);
        $lecture->lecture_name = $request->lecture_name;
        $lecture->lecture_text = $request->lecture_text;
        $numberLecture = mt_rand(0, 10000);
        if ($request->hasFile('doc_file')) {
            if ($request->file('doc_file')->isValid()) {
                $mimetypes = new MimeType;
                $nameDocFile = "TA_lec".$numberLecture;
                switch ($mimetypes->guess($request->file('doc_file')->getMimeType())) {
                    case "doc":
                        $nameDocFile = mt_rand(0, 10000) . $nameDocFile.".doc";
                        break;
                    case "docx":
                        $nameDocFile = mt_rand(0, 10000) . $nameDocFile.".docx";
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
                $namePptFile = "TA_lec".$numberLecture;
                switch ($mimetypes->guess($request->file('ppt_file')->getMimeType())) {
                    case "ppt":
                        $namePptFile = mt_rand(0, 10000) . $namePptFile.".ppt";
                        break;
                    case "pptx":
                        $namePptFile = mt_rand(0, 10000) . $namePptFile.".pptx";
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
        DB::update('UPDATE `definition` SET `idLecture` = NULL, `nameAnchor` = NULL where `idLecture` = ?', [$id]);

        DB::update('UPDATE `theorems` SET `idLecture` = NULL, `nameAnchor` = NULL where `idLecture` = ?', [$id]);

        DB::update('UPDATE `lectures` SET `lecture_number` = `lecture_number` - 1 where `lecture_number` > ?', [$lecture->lecture_number]);
        // Удаление тем из таблицы themes по id лекции
        DB::update('UPDATE `themes` SET `id_lecture` = NULL where `id_lecture` = ?', [$id]);
        $lecture->delete();
        return 'ok';
    }
}