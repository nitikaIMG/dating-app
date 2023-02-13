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
        Schema::create('usersdetails', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->unique();
            $table->string('name');
            $table->date('dob');
            $table->string('gender')->comment('0=>Mail,1=>Femail,2=>Other');
            $table->string('interests')->comment('0=>Mail,1=>Femail,2=>Other');
            $table->string('photos'); 
            $table->string('deleted_at')->comment('1=>deleted')->default(0); 
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
        Schema::dropIfExists('usersdetails');
    }
};
