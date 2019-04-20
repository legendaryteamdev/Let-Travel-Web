<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtsMosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mts_mos', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('mt_id')->unsigned()->index()->nullable();
            $table->foreign('mt_id')->references('id')->on('mt')->onDelete('cascade');
            
            $table->integer('mo_id')->unsigned()->index()->nullable();
            $table->foreign('mo_id')->references('id')->on('mo')->onDelete('cascade');

            $table->longText('description')->nullable();

            $table->integer('creator_id')->unsigned()->index()->nullable();
            $table->integer('updater_id')->unsigned()->index()->nullable();
            $table->integer('deleter_id')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('mts_mos');
    }
}
