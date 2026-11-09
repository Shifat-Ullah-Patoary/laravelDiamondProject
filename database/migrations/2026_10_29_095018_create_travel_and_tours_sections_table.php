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
        Schema::create('travel_and_tours_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('travel_and_tours_page_setting_id');
            $table->foreign(
                'travel_and_tours_page_setting_id',
                'tats_page_setting_fk'
            )
                ->references('id')
                ->on('travel_and_tours_page_settings')
                ->cascadeOnDelete();
            $table->string('badge')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->text('description_1');
            $table->text('description_2');
            $table->string('image')->nullable();
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_and_tours_sections');
    }
};
