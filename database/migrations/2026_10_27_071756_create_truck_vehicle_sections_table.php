<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('truck_vehicle_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_details_page_setting_id')
                ->constrained()
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

        $settings = DB::table('truck_details_page_settings')->get();

        foreach ($settings as $setting) {
            $now = now();

            DB::table('truck_vehicle_sections')->insert([
                [
                    'truck_details_page_setting_id' => $setting->id,
                    'badge' => $setting->vehicle_one_badge ?? 'Truck Service',
                    'title' => $setting->vehicle_one_title ?? 'Truck Name',
                    'subtitle' => $setting->vehicle_one_subtitle ?? 'Reliable Transport Service',
                    'description_1' => $setting->vehicle_one_description_1 ?? 'Diamond Group provides dependable transport solutions to help businesses move goods and materials efficiently.',
                    'description_2' => $setting->vehicle_one_description_2 ?? 'Our commitment to reliable service, customer satisfaction, and professional transportation helps keep your business moving.',
                    'image' => $setting->vehicle_one_image,
                    'position' => 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
                [
                    'truck_details_page_setting_id' => $setting->id,
                    'badge' => $setting->vehicle_two_badge ?? 'Transportation Solutions',
                    'title' => $setting->vehicle_two_title ?? 'Moving Your Business Forward',
                    'subtitle' => $setting->vehicle_two_subtitle ?? 'Dependable Vehicles. Reliable Service.',
                    'description_1' => $setting->vehicle_two_description_1 ?? 'Our transport services support businesses with practical vehicle solutions for moving goods and materials.',
                    'description_2' => $setting->vehicle_two_description_2 ?? 'From everyday transportation needs to business logistics, Diamond Group is committed to dependable service and customer satisfaction.',
                    'image' => $setting->vehicle_two_image,
                    'position' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('truck_vehicle_sections');
    }
};
