<?php
/**
 * Created by PhpStorm.
 * User: oksana.sedova
 * Date: 27.02.2016
 * Time: 13:21
 */

namespace App;
use App\Testing\Lecture;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * @method static \Illuminate\Database\Query\Builder|\App\Question whereId_question($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereAnswer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Question  whereControl($value)
 * @method static \Illuminate\Database\Eloquent|\App\Question  get()
 * @method static \Illuminate\Database\Eloquent|\App\Question  where()
 * @method static \Illuminate\Database\Eloquent|\App\Question  whereRaw()
 * @method static \Illuminate\Database\Eloquent|\App\Question  orWhere()
 * @method static \Illuminate\Database\Eloquent|\App\Question  select()
 * @method static \Illuminate\Database\Eloquent|\App\Question  first()
 * @method static \Illuminate\Database\Eloquent|\App\Question  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Question  count()
 * @method static \Illuminate\Database\Eloquent|\App\Question  toSql()
 *
 */
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