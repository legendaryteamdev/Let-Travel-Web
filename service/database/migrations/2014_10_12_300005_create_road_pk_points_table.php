<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadPkPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_pk_points', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('pk_id')->unsigned()->index()->nullable();
            $table->foreign('pk_id')->references('id')->on('road_pks')->onDelete('cascade');
            
            $table->integer('meter')->unsigned()->index()->nullable();
            $table->json('latlng')->nullable(); //LatLng
            $table->point('point')->nullable();//Coordinates
            
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
        Schema::dropIfExists('road_pk_points');
    }
}
