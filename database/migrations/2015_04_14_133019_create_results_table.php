<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('results', function(Blueprint $table)
		{
            $table->increments('id_result');
            $table->integer('id_user');      //идентификатор пользователя
            $table->integer('id_test');      //связь с таблицей тестов через идентификатор типа теста
            $table->string('test_name');     //связь с таблицей тестов через имя теста
            $table->integer('amount');       //количество вопросов берем из таблицы тестов
            $table->dateTime('result_date'); //время получения результата теста
            $table->integer('result');        //количество баллов, полученное за пройденный тест
            $table->integer('mark_ru');       //оценка за тест в российской системе
            $table->string('mark_eu', 10);        //оценка за тест по болонской системе
            $table->string('saved_test', 50000);    //сериализованный текст теста
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('results');
	}

}
