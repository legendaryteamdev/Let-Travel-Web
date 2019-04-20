<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMosRoadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mos_roads', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('mo_id')->unsigned()->index()->nullable();
            $table->foreign('mo_id')->references('id')->on('mo')->onDelete('cascade');

            $table->integer('road_id')->unsigned()->index()->nullable();
            $table->foreign('road_id')->references('id')->on('road')->onDelete('cascade');

            $table->integer('start_pk')->unsigned()->index()->nullable();
            $table->integer('end_pk')->unsigned()->index()->nullable();
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
        Schema::dropIfExists('mos_roads');
    }
}
