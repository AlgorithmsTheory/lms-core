<?php

namespace App\Emulators;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TestsequencePost extends Eloquent {
    protected $table = 'testsequence_post';
    public $timestamps = false;
    protected $fillable = ['sequense_id', 'input_word', 'output_word', 'task_id'];
} 