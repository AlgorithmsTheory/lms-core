<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Tasks_post extends Eloquent {
    protected $table = 'tasks_post';
    public $timestamps = false;
    protected $fillable = ['task_id', 'level', 'mark', 'variant', 'description'];
} 