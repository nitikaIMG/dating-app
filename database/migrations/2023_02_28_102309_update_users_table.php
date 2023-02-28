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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('age_status')->after('longitude')->nullable()->default(0)->comment('0=>show,1=>hide');
            $table->integer('distance_status')->after('age_status')->nullable()->default(0)->comment('0=>show,1=>hide');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('age_status');
            $table->dropColumn('distance_status');
        });
    }
};
