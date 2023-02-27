<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('session_id')->nullable();
            $table->text('active_device_id')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('phone')->nullable()->unique();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('gender', 10)
                ->nullable()
                ->comment('m,f,o');
            $table->tinyInteger('status')
                ->default(1)
                ->comment('1=Active,0=Blocked');
            $table->string('refer_code', 191)->nullable();
            $table->bigInteger('refer_by')->default(0);
            $table->string('platform')->nullable();
            $table->string('social_login_with')->nullable();
            $table->string('social_id')->nullable();
            $table->string('social_session_id')->nullable();;
            $table->text('referred_from')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
