<?php


namespace App;
use App\Testing\Lecture;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Definition extends Eloquent {
    protected $table = 'definition';
    public $timestamps = false;
    protected $appends = ['link_to_lecture'];
    /** По id лекции возвращает строку, где первый элемент - номер лекции, второй - название якоря */
    public function getLinkToLectureAttribute(){
        $resultlink = '';
        $idLecture = $this->attributes['idLecture'];
        if (!is_null($idLecture)){
            $lecture_number = Lecture::where('id_lecture', $idLecture)->select('lecture_number')->first()->lecture_number;
            $resultlink = $lecture_number.'#'.$this->attributes['nameAnchor'];
        }
        return $resultlink;
    }
}