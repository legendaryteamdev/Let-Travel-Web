<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_parts', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('road_id')->unsigned()->index()->nullable();
            $table->foreign('road_id')->references('id')->on('road')->onDelete('cascade');

            $table->integer('type_id')->unsigned()->index()->nullable();
            $table->foreign('type_id')->references('id')->on('roads_type')->onDelete('cascade');
            
            $table->integer('object_id')->unsigned()->index()->nullable();
            $table->lineString('line')->nullable();
            $table->json('start')->nullable(); //LatLng
            $table->json('end')->nullable(); //LatLng
            $table->decimal('length', 20, 10)->unsigned()->index()->nullable();

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
        Schema::dropIfExists('road_parts');
    }
}
