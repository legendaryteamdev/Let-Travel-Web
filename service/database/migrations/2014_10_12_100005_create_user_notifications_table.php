<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_notifications', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('user_id')->unsigned()->index()->nullable();
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');

            $table->string('title', 250)->nullable();
            $table->string('description', 450)->nullable();
            $table->string('image', 50)->nullable();
            $table->string('type', 50)->nullable(); //Normal, Success, Warning
            $table->string('way', 50)->nullable(); //phone | email | firebase | telegram | messenger
            $table->string('action', 50)->nullable(); 
            $table->string('action_id', 50)->nullable(); 
            $table->boolean('is_seen')->default(0);
            $table->dateTime('seen_at')->nullable();

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
        Schema::dropIfExists('user_notifications');
    }
}
