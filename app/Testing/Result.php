<?php

namespace App\Testing;

/**
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result whereId_result($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereId($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereId_test($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereResult_date($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereResult($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereMark_eu($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereMark_ru($value)
* @method static \Illuminate\Database\Query\Builder|\App\Testing\Result  whereSaved_test($value)
 *
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  get()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  where()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  update($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  orWhere()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  select()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  first()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  insert($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  table($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  max($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  count()
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  orderBy($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  limit($array)
* @method static \Illuminate\Database\Eloquent|\App\Testing\Result  take($array)
*
* Строка таблицы results хранит попытку сдачи контрольной (теста).
* До начала попытки прохождения студентом контрольной соответствующей строки в таблице results нет.
* Столбцы:
* 1) id_result - идентификатор строки таблицы
* 2) result_date - момент, до которого нужно успеть сдать контрольную
* 3) result - число полученный баллов за попытку от 0 до x
* 4) mark_ru - оценка от 2 до 5
* 5) mark_eu - оценка от F до A
* 6) saved_test - сохранённые ответы студента для данной попытки
* 7) id_test - идентификатор контрольной
* 8) id - идентификатор студента
* Если попытка прохождения контрольной была начата, но ещё не завершена, то столбцы
* result, mark_ru, mark_eu содержат значения null.
*/
class Result extends \Eloquent {
    protected $table = 'results';
    public $timestamps = false;
    protected $fillable = ['*'];

    /** 
     * Возвращает идентификатор попытки прохождения контрольной с id = $id_test
     * студентом с id = $id_user, которая была начата, но ещё не была завершена.
     * Если такой попытки нет, то возвращает -1.
     */
    public static function getCurrentResult($id_user, $id_test){
        $result = -1;
        $query = Result::whereId($id_user)
            ->whereId_test($id_test)
            ->whereNull('result')
            ->select('id_result')
            ->get();
        if (count($query) == 1){
            foreach ($query as $res){
                $result = $res->id_result;
            }
        }
        return $result;
    }
}