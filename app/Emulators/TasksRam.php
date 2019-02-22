<?php

namespace App\Emulators;
use Illuminate\Database\Eloquent\Model as Eloquent;

class TasksRam extends Eloquent {
    protected $table = 'tasks_ram';
    public $timestamps = false;
    protected $fillable = ['task_id', 'level', 'mark', 'variant', 'description'];
} 