<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('description', function (Blueprint $table) {
            
            $table->increments('id', 11);
            $table->integer('resort_id')->unsigned()->nullable();
            $table->integer('season_id')->unsigned()->nullable();

            $table->string('activity', 350)->default('');
            $table->string('food', 350)->default('');
            $table->string('homestay', 350)->default('');

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
        Schema::dropIfExists('description');
    }
}
