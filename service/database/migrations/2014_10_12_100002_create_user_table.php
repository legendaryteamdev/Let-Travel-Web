<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id', 11);
            
            $table->integer('type_id')->unsigned()->index()->nullable();
            $table->foreign('type_id')->references('id')->on('users_type')->onDelete('cascade');

            $table->string('name', 50)->nullable();
            $table->string('avatar', 100)->default('public/user/profile.png');

            $table->string('phone', 50)->unique()->nullable();
            $table->boolean('is_phone_verified')->default(0);
            $table->dateTime('phone_verified_at')->nullable();
            $table->string('phone_verified_code', 50)->nullable();

            $table->string('email', 50)->unique()->nullable();
            $table->boolean('is_email_verified')->default(0);
            $table->dateTime('email_verified_at')->nullable();
            $table->string('email_verified_code', 50)->nullable();

            $table->boolean('is_telegram_linked')->default(0);
            $table->dateTime('telegram_linked_date')->nullable();
            $table->string('telegram_chat_id', 100)->nullable();

            $table->boolean('is_google2fa_enable')->default(0);
            $table->dateTime('google2fa_enable_at')->nullable();
            $table->string('google2fa_secret', 200)->nullable();

            $table->integer('social_type_id')->unsigned()->index()->nullable();
            $table->foreign('social_type_id')->references('id')->on('users_social')->onDelete('cascade');
            $table->string('social_id', 50)->unique()->nullable();
           

            $table->string('password');
            $table->dateTime('password_last_updated_at')->nullable();
            $table->dateTime('password_last_updater')->nullable();
            $table->boolean('is_notified_when_login')->default(1);
            $table->boolean('is_notified_when_login_with_unknown_device')->default(1);
            $table->boolean('is_active')->default(1);
            $table->string('lang', 5)->default('kh');
            $table->string('device', 10)->nullable();
            $table->string('app_token', 250)->nullable();

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
        Schema::dropIfExists('user');
    }
}
