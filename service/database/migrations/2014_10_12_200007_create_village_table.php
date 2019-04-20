<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVillageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('village', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('commune_id')->unsigned()->index()->nullable();
            $table->foreign('commune_id')->references('id')->on('commune')->onDelete('cascade');

            $table->string('code', 10)->default('');
            $table->string('name', 150)->default('');
            
            $table->geometry('boundary')->nullable();
            $table->point('central')->nullable();//   Coordinates         
            $table->json('latlng')->nullable(); //LatLng
            
            //Will remove
            $table->string('lat', 20)->nullable(); 
            $table->string('lng', 20)->nullable();

            
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
        Schema::dropIfExists('village');
    }
}
