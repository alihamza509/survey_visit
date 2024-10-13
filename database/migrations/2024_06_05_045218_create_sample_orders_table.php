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
        Schema::create('sample_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->string('sample_order')->nullable();
            $table->string('GST_details')->nullable();
            $table->string('photo_of_product')->nullable();
            $table->text('comments_of_meeting')->nullable();

            $table->foreign('shop_id')->references('id')->on('survey_visits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_orders');
    }
};
