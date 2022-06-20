<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mt_fees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('debug_fee');
            $table->integer('check_syntax_fee');
            $table->integer('run_fee');
        });
        DB::table('mt_fees')->insert(
            array(
                'debug_fee' => 15,
                'check_syntax_fee' => 5,
                'run_fee' => 10,
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
        Schema::drop('mt_fees');
    }
}
