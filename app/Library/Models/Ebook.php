<?php

namespace App\Library\Models;
use Illuminate\Database\Eloquent\Model as Eloquent;


class Ebook extends Eloquent {
    protected $table = 'ebook';
    public $timestamps = false;
    public $primaryKey = 'id_ebook';
}