<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('map', function (Blueprint $table) {
            $table->increments('id', 11);
          

            $table->string('url', 150)->default('');

            $table->geometry('boundary')->nullable();
            $table->point('central')->nullable();//   Coordinates         
            $table->json('latlng')->nullable(); //LatLng
            
            //Will remove
            $table->string('lat', 20)->nullable(); 
            $table->string('lng', 20)->nullable();

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
        Schema::dropIfExists('map');
    }
}
