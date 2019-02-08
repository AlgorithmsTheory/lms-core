<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Tasks_ram extends Eloquent {
    protected $table = 'tasks_ram';
    public $timestamps = false;
    protected $fillable = ['task_id', 'level', 'mark', 'variant', 'description'];
} 