<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order_book extends Model
{
    protected $table = 'order_books';
    public $timestamps = false;
    protected $fillable = ['id','id_user', 'id_book', 'date_order','status'];
}
