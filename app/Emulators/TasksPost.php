<?php

namespace App\Emulators;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TasksPost extends Eloquent {
    protected $table = 'tasks_post';
    public $timestamps = false;
    protected $fillable = ['task_id', 'level', 'mark', 'variant', 'description'];
} 