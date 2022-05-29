<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHamFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ham_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('debug_fee');
            $table->integer('run_fee');
            $table->integer('steps_fee');
        });
        DB::table('ham_fees')->insert(
            array(
                'debug_fee' => 15,
                'run_fee' => 10,
                'steps_fee' => 12,
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ham_fees');
    }
}
