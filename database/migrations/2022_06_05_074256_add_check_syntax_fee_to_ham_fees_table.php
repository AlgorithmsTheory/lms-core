<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckSyntaxFeeToHamFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ham_fees', function (Blueprint $table) {
            $table->integer('check_syntax_fee');
        });
        DB::table('ham_fees')->update([
            "check_syntax_fee" => 5,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ham_fees', function (Blueprint $table) {
            $table->dropColumn('check_syntax_fee');
        });
    }
}
