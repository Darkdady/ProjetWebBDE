<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NullableForeignOnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['picture_id']);
            $table->dropColumn('picture_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('picture_id')->unsigned()->nullable();
            $table->foreign('picture_id')->references('id')->on('pictures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['picture_id']);
            $table->dropColumn('picture_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('picture_id')->unsigned();
            $table->foreign('picture_id')->references('id')->on('pictures');
        });
    }
}
