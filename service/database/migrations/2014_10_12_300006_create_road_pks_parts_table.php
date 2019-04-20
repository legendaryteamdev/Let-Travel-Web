<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadPksPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_pks_parts', function (Blueprint $table) {
            $table->increments('id', 11);
            
        
            $table->integer('pk_id')->unsigned()->index()->nullable();
            $table->foreign('pk_id')->references('id')->on('road_pks')->onDelete('cascade');

            $table->integer('part_id')->unsigned()->index()->nullable();
            $table->foreign('part_id')->references('id')->on('road_parts')->onDelete('cascade');
           
            $table->json('start_ll')->nullable(); //LatLng on part
            $table->json('end_ll')->nullable(); //LatLng on part
            
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
        Schema::dropIfExists('road_pks_parts');
    }
}
