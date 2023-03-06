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
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->text('plan_name')->nullable();
            $table->float('price', 8, 2)->nullable();
            $table->integer('unlimited_likes')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('see_who_likes_you')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('priority_likes')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('unlimited_rewinds')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('1_free_boost_per_month')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('5_free_super_likes_per_week')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('message_before_matching')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('passport')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('top_pics')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('control_your_profile')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('control_who_sees_you')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('control_who_you_see')->nullable()->comment('0=>deactive plan, 1=>active plan');
            $table->integer('hide_ads')->nullable()->comment('0=>deactive plan, 1=>active plan');
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
        Schema::dropIfExists('subscription_plans');
    }
};
