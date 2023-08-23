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
        Schema::create('privacy_terms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullabel();
            $table->longtext('privacy_page')->nullable();
            $table->integer('status')->comment('1->active, 0->deactive')->nullable();
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
        Schema::dropIfExists('privacy_terms');
    }
};
