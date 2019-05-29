<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('season', function (Blueprint $table) {
            $table->increments('id', 11);

            $table->string('kh_name', 150)->default('');
            $table->string('en_name', 150)->default('');
            

            $table->integer('creator_id')->unsigned()->nullable();
            $table->integer('updater_id')->unsigned()->nullable();
            $table->integer('deleter_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('season');
    }
}
