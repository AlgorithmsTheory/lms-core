<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CraeteQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->increments('id_question');
            $table->boolean('control'); //контрольный или неконтрольный вопрос (контрольный не доступен для тренировочных тестов_

            $table->string('code');     //идентификационный номер в дереве раздел->тема->тип 1.2.1
            $table->string('title', 1000);   //Текст вопроса
            $table->string('variants', 1000); //варианты ответа, если есть
            $table->string('answer', 1000);  //Ответ на вопрос
			$table->integer('points'); //Количество баллов за вопрос
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questions');
	}

}
