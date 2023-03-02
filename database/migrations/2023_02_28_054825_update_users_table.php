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
            $table->longText('about_me')->after('interests')->nullable();
            $table->string('life_interests')->after('about_me')->nullable();
            $table->string('relationship_goals')->after('life_interests')->nullable();
            $table->string('life_style')->after('relationship_goals')->nullable();
            $table->string('job_title')->after('life_style')->nullable();
            $table->string('company')->after('job_title')->nullable();
            $table->string('school')->after('company')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_info', function (Blueprint $table) {
            $table->dropColumn('about_me');
            $table->dropColumn('life_interests');
            $table->dropColumn('relationship_goals');
            $table->dropColumn('life_style');
            $table->dropColumn('job_title');
            $table->dropColumn('company');
            $table->dropColumn('school');
        });
    }
};
