<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePotholeLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pothole_location', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('pothole_id')->unsigned()->index()->nullable();
            $table->foreign('pothole_id')->references('id')->on('pothole')->onDelete('cascade');

            $table->integer('village_id')->unsigned()->index()->nullable();
            $table->foreign('village_id')->references('id')->on('village')->onDelete('cascade');

            $table->integer('commune_id')->unsigned()->index()->nullable();
            $table->foreign('commune_id')->references('id')->on('commune')->onDelete('cascade');

            $table->integer('district_id')->unsigned()->index()->nullable();
            $table->foreign('district_id')->references('id')->on('district')->onDelete('cascade');

            $table->integer('province_id')->unsigned()->index()->nullable();
            $table->foreign('province_id')->references('id')->on('province')->onDelete('cascade');

            $table->multiPoint('points')->nullable();
            $table->string('lat', 20)->nullable(); 
            $table->string('lng', 20)->nullable(); 
            
           
            $table->integer('creator_id')->unsigned()->index()->nullable();
            $table->timestamps();
            //$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pothole_location');
    }
}
