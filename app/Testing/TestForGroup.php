<?php
/**
 * Created by PhpStorm.
 * User: Станислав
 * Date: 22.10.16
 * Time: 18:14
 */

namespace App\Testing;
use Illuminate\Database\Eloquent\Model as Eloquent;


/**
 * @method static \Illuminate\Database\Query\Builder|TestForGroup  whereId_test_for_group($value)
 * @method static \Illuminate\Database\Query\Builder|TestForGroup  whereId_test($value)
 * @method static \Illuminate\Database\Query\Builder|TestForGroup  whereId_group($value)
 * @method static \Illuminate\Database\Query\Builder|TestForGroup  whereAvailability($value)
 */

class TestForGroup extends Eloquent{
    protected $table = 'test_for_group';
    public $timestamps = false;
    protected $fillable = ['id_test', 'id_group', 'start', 'end'];
} 