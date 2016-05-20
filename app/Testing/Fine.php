<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 27.02.16
 * Time: 19:43
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Fine whereId_fine($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Fine  whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Fine  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Fine  whereFine($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Testing\Fine  whereAccess($value)
 *
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  get()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  where()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  select()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  first()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  insert($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  table($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Fine  max($array)
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  join()
 * @method static \Illuminate\Database\Eloquent|\App\Testing\Theme  on()
 *
 */

class Fine extends Eloquent{
    const MAX_FINE = 5;                                                                                                 //максимально возможный уровень штрафа
    protected $Fines = 'fines';
    public $timestamps = false;

    /** Следит, чтобы штраф не стал больше максимально возможного уровня */
    public function maxFine($fine){
        if ($fine > $this::MAX_FINE){
            return $this::MAX_FINE;
        }
        else return $fine;
    }

    /** вносим изменнеия в таблицу штрафов при отправлении контрольного теста */
    public function updateFine($user, $test, $mark){
        $query_fine = $this->whereId($user)->whereId_test($test)->first();
        if (is_null($query_fine)){                                                                                      //если в таблице штрафов еще не зафиксировано прохождение данного контрольного теста данным студентом
            if ($mark > 2) {                                                                                            //если оценка положительная
                Fine::insert(array('id' => $user, 'id_test' => $test, 'fine' => 0, 'access' => false));            //штраф не начисляется
            }
            else Fine::insert(array('id' => $user, 'id_test' => $test, 'fine' => 1, 'access' => false));           //штраф начисляется
        }
        else {
            if ($mark > 2) {                                                                                            //если оценка положительная
                Fine::whereId_fine($query_fine->id_fine)->update(array('access' => false));                                                                 //штраф не начисляется
            }
            else Fine::whereId_fine($query_fine->id_fine)->update(array('id' => $user, 'id_test' => $test, 'fine' => $this->maxFine($query_fine->fine + 1), 'access' => false));   //штраф начисляется
        }
    }

    /** По уровню штрафа (0..5) высчитывает коэффициент, на который будет умножаться результат штрафника */
    public function countFactor($fine){
        $factor = 1 - $fine/10;
        return $factor;
    }

    /** Преобразует уровень штрафа в максимальный процент */
    public static function levelToPercent($fine){
        if ($fine != 0)
            $percent = 90 - ($fine-1)*5;
        else $percent = 100;
        return $percent;
    }

    /** Преобразует процент в уровень штрафа */
    public static function percentToLevel($percent){
        if ($percent != 100)
            $fine = 19 - $percent/5;
        else $fine = 0;
        return $fine;
    }
} 