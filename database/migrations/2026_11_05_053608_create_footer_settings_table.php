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
        Schema::create('footer_settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('Diamond Group');
            $table->text('description')->nullable();
            $table->string('facebook_url')->default('https://facebook.com/yourpage');
            $table->string('instagram_url')->default('https://instagram.com/yourpage');
            $table->string('linkedin_url')->default('https://linkedin.com/company/yourcompany');
            $table->string('whatsapp_url')->default('https://wa.me/8801XXXXXXXXX');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('footer_settings');
    }
};
