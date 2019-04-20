<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVerifiedCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verified_codes', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');

            $table->string('type', 50)->nullable(); // PHONE or EMAIL
            $table->string('code', 50)->unique();
            $table->boolean('is_verified')->default(0);
            $table->dateTime('verified_at')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_verified_codes');
    }
}
