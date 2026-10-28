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
        Schema::create('truck_details_page_settings', function (Blueprint $table) {
            $table->id();
            $table->string('header_badge')->nullable();
            $table->string('header_title_part_1')->nullable();
            $table->string('header_title_part_2')->nullable();
            $table->text('header_description')->nullable();
            $table->string('header_image')->nullable();
            $table->string('vehicle_one_badge')->nullable();
            $table->string('vehicle_one_title')->nullable();
            $table->string('vehicle_one_subtitle')->nullable();
            $table->text('vehicle_one_description_1')->nullable();
            $table->text('vehicle_one_description_2')->nullable();
            $table->string('vehicle_one_image')->nullable();
            $table->string('vehicle_two_badge')->nullable();
            $table->string('vehicle_two_title')->nullable();
            $table->string('vehicle_two_subtitle')->nullable();
            $table->text('vehicle_two_description_1')->nullable();
            $table->text('vehicle_two_description_2')->nullable();
            $table->string('vehicle_two_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_details_page_settings');
    }
};
