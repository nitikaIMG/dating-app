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
        Schema::table('user_info', function (Blueprint $table) {
            $table->integer('zodiac')->nullable()->after('life_style');
            $table->integer('education')->nullable()->after('zodiac');
            $table->integer('personality_type')->nullable()->after('education');
            $table->integer('communication_style')->nullable()->after('personality_type');
            $table->integer('children')->nullable()->after('communication_style');
            $table->integer('receive_love')->nullable()->after('children');
            $table->integer('relationship_types')->nullable()->after('receive_love');
            $table->integer('vaccine')->nullable()->after('relationship_types');
            $table->integer('pet')->nullable()->after('vaccine');
            $table->integer('drink')->nullable()->after('pet');
            $table->integer('smoke')->nullable()->after('drink');
            $table->integer('dietary')->nullable()->after('smoke');
            $table->integer('sleeping_habit')->nullable()->after('dietary');
            $table->integer('workout')->nullable()->after('sleeping_habit');
            $table->integer('language')->nullable()->after('workout');
            $table->integer('passion')->nullable()->after('language');
            $table->integer('sexualorientation')->nullable()->after('passion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userinfo');
    }
};
