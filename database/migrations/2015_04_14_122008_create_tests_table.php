<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tests', function(Blueprint $table)
		{
			$table->increments('id_test');
			$table->string('test_name');  //имя теста
			$table->integer('amount');    //количество вопрососв в тесте
            $table->integer('test_time');  //время на выполнение теста
            $table->dateTime('start');    //время открытия теста
            $table->dateTime('end');     //время закрытия теста
            $table->string('structure');  //строка из трехзначных кодов вопросов  3-1.2.4;1-2.4.2
            $table->integer('total');    //общий за тест
        });
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tests');
	}

}
