<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fines', function(Blueprint $table)
        {
            $table->increments('id_fine');
            $table->integer('id_user');             //пользователь
            $table->integer('id_test');             //тест
            $table->integer('fine');                //штраф (от 0 до 5 уровней)
            $table->boolean('access');              //возможность переписывать (1 - есть возможность, 0 - нет возможности)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fines');
    }
}
