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
        Schema::create('blockusers', function (Blueprint $table) {
            $table->id();
            $table->integer('blocked_by')->nullable();
            $table->integer('blocked_to')->nullable();
            $table->integer('block_status')->nullable()->default(0)->comment('0=>unblock,1=>block');
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
        Schema::dropIfExists('blockusers');
    }
};
