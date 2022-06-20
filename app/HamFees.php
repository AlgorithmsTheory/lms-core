<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent|\App\Question  first()
 */
class HamFees extends Model {
    protected $table = 'ham_fees';
    public $timestamps = false;
    protected $fillable = ['debug_fee', 'run_fee', 'steps_fee', 'check_syntax_fee'];
}
