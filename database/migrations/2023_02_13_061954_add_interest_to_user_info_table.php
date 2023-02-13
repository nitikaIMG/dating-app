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
            $table->string('interests')->comment('0=>Mail,1=>Femail,2=>Other')->nullable()->after('country');
            $table->string('photos')->nullable()->after('interests'); 
            $table->string('deleted_at')->comment('1=>deleted')->default(0); 
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
            $table->dropColumn('interests');
            $table->dropColumn('photos');
            $table->dropColumn('deleted_at');
        });
    }
};
