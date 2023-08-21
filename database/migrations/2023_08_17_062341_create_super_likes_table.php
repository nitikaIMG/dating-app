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
        Schema::create('super_likes', function (Blueprint $table) {
            $table->id();
            $table->integer('sender_id')->nullable();
            $table->integer('super_like_user_id')->nullable();
            $table->integer('super_like_status')->comment('0 => unlike 1=> super_like')->nullable();
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
        Schema::dropIfExists('super_likes');
    }
};
