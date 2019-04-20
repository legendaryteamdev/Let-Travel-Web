<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMosMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mos_ministries', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('mo_id')->unsigned()->index()->nullable();
            $table->foreign('mo_id')->references('id')->on('mo')->onDelete('cascade');

            $table->integer('ministry_id')->unsigned()->index()->nullable();
            $table->foreign('ministry_id')->references('id')->on('ministry')->onDelete('cascade');
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
        Schema::dropIfExists('mos_ministries');
    }
}
