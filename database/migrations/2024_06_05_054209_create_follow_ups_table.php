<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('user_id');
            $table->string('photo_display_of_battu')->nullable();
            $table->string('trial_order')->nullable();
            $table->date('potential_order_horizon')->nullable();
            $table->string('payment_preference')->nullable();
            $table->text('comments_of_meeting')->nullable();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('survey_visits')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
