<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Testsequence_ram extends Eloquent {
    protected $table = 'testsequence_ram';
    public $timestamps = false;
    protected $fillable = ['sequense_id', 'input_word', 'output_word', 'task_id'];
} 