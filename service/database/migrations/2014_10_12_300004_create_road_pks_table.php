<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoadPksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('road_pks', function (Blueprint $table) {
            $table->increments('id', 11);

            $table->integer('road_id')->unsigned()->index()->nullable();
            $table->foreign('road_id')->references('id')->on('road')->onDelete('cascade');
            
            $table->integer('code')->unsigned()->index()->nullable();
            // $table->lineString('line')->nullable();
            // $table->json('start_ll')->nullable(); //LatLng
            // $table->json('end_ll')->nullable(); //LatLng
            // $table->decimal('length', 10, 2)->unsigned()->index()->nullable();

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
        Schema::dropIfExists('road_pks');
    }
}
