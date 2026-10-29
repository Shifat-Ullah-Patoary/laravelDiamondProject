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
        Schema::create('travel_and_tours_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_badge')->nullable();
            $table->string('header_title_part_1')->nullable();
            $table->string('header_title_part_2')->nullable();
            $table->text('header_description')->nullable();
            $table->string('header_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_and_tours_page_settings');
    }
};
