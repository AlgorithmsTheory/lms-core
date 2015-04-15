<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodificatorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('codificators', function(Blueprint $table)
		{
			$table->increments('id_codificator');
			$table->string('codificator_type');    //тип (раздел, тема, тип вопроса)
			$table->string('value');               //значение кодификатора
			$table->string('code');                //идентификационный номер в дереве раздел->тема->тип 1.2.1
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('codificators');
	}

}
