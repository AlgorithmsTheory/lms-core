<?php

namespace App;
use Illuminate\Database\Eloquent\Model as Eloquent;

class EmrForGroup extends Eloquent {
    protected $table = 'emr_for_group';
    public $timestamps = false;
	protected $fillable = ['id', 'emr_id', 'group_id', 'availability'];
}