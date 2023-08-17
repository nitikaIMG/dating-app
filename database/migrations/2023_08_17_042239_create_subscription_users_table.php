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
        Schema::create('subscription_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->integer('months')->comment('1->months, 6->months, 12->months')->nullable();
            $table->integer('free_boost_per_month')->comment('1 per month')->nullable();
            $table->integer('boost_status')->comment('0->not usaable, 1->Active profile in boost mode')->nullable();
            $table->integer('free_super_like')->comment('5 per month')->nullable();
            $table->integer('status')->default('1')->comment('1=>Active,0=>deactive');
            $table->dateTime('expire_date')->nullable();
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
        Schema::dropIfExists('subscription_users');
    }
};
