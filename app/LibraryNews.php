<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LibraryNews extends Model
{
    protected $table = 'library_news';
    public $timestamps = false;
    protected $fillable = ['id', 'title', 'description'];
}
