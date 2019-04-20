<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadPkPointsCommunesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('communes_points', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('commune_id')->unsigned()->index()->nullable();
            $table->foreign('commune_id')->references('id')->on('commune')->onDelete('cascade');

            $table->integer('point_id')->unsigned()->index()->nullable();
            $table->foreign('point_id')->references('id')->on('road_pk_points')->onDelete('cascade');

            $table->double('length')->nullable();
           
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
        Schema::dropIfExists('communes_points');
    }
}
