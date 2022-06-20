<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent|\App\Question  first()
 */
class MtFees extends Model {
    protected $table = 'mt_fees';
    public $timestamps = false;
    protected $fillable = ['debug_fee', 'check_syntax_fee', 'run_fee'];
}