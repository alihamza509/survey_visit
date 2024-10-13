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
        Schema::create('trail_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->unsignedBigInteger('user_id');
            $table->string('photo_display_of_battu')->nullable();
            $table->string('types_of_order')->nullable();
            $table->date('potential_order_horizon')->nullable();
            $table->integer('order_quantity')->nullable();
            $table->date('order_delivery_calendar')->nullable();
            $table->text('meeting_discussion_summary')->nullable();
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
        Schema::dropIfExists('trail_orders');
    }
};
