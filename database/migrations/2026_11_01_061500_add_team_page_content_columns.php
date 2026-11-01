<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_page_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('team_page_settings', 'section_header_top')) {
                $table->string('section_header_top')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'section_header_middle')) {
                $table->string('section_header_middle')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'section_header_bottom')) {
                $table->text('section_header_bottom')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'founder_image')) {
                $table->string('founder_image')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'founder_header_top')) {
                $table->string('founder_header_top')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'founder_name')) {
                $table->string('founder_name')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'designation')) {
                $table->string('designation')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'founder_description')) {
                $table->text('founder_description')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'member_heading')) {
                $table->string('member_heading')->nullable();
            }
            if (! Schema::hasColumn('team_page_settings', 'member_description')) {
                $table->text('member_description')->nullable();
            }
        });

        Schema::table('team_members', function (Blueprint $table) {
            if (! Schema::hasColumn('team_members', 'team_page_setting_id')) {
                $table->foreignId('team_page_setting_id')
                    ->nullable()
                    ->constrained('team_page_settings')
                    ->cascadeOnDelete();
            }
            if (! Schema::hasColumn('team_members', 'name')) {
                $table->string('name')->nullable();
            }
            if (! Schema::hasColumn('team_members', 'position')) {
                $table->string('position')->nullable();
            }
            if (! Schema::hasColumn('team_members', 'description')) {
                $table->text('description')->nullable();
            }
            if (! Schema::hasColumn('team_members', 'image')) {
                $table->string('image')->nullable();
            }
            if (! Schema::hasColumn('team_members', 'position_order')) {
                $table->unsignedInteger('position_order')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropForeign(['team_page_setting_id']);
            $table->dropColumn([
                'team_page_setting_id',
                'name',
                'position',
                'description',
                'image',
                'position_order',
            ]);
        });

        Schema::table('team_page_settings', function (Blueprint $table) {
            $table->dropColumn([
                'section_header_top',
                'section_header_middle',
                'section_header_bottom',
                'founder_image',
                'founder_header_top',
                'founder_name',
                'designation',
                'founder_description',
                'member_heading',
                'member_description',
            ]);
        });
    }
};
