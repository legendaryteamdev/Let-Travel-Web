<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvinceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('province', function (Blueprint $table) {
            
              $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->increments('id', 11);

            $table->string('code', 10)->default('');
            $table->string('name', 150)->default('');
            $table->string('en_name', 150)->default('');
            $table->string('abbre', 150)->default('');
            
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
        Schema::dropIfExists('province');
    }
}
