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
        Schema::create('prefer_list', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('age_status')->comment('1->active, 0->deactive')->nullable();
            $table->integer('first_age')->nullable();   
            $table->integer('second_age')->nullable();
            $table->string('distance_status')->comment('1->active, 0->deactive')->nullable();
            $table->text('first_distance')->nullable();
            $table->text('second_distance')->nullable();
            $table->string('show_me_to')->nullable();
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
        Schema::dropIfExists('prefer_list');
    }
};
