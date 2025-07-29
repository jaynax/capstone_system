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
        Schema::table('catches', function (Blueprint $table) {
            // General Information
            $table->string('region')->nullable();
            $table->string('landing_center')->nullable();
            $table->date('date_sampling')->nullable();
            $table->time('time_landing')->nullable();
            $table->string('enumerators')->nullable();
            $table->string('fishing_ground')->nullable();
            $table->string('weather_conditions')->nullable();
            
            // Boat Information
            $table->string('boat_name')->nullable();
            $table->string('boat_type')->nullable();
            $table->decimal('boat_length', 5, 2)->nullable();
            $table->decimal('boat_width', 5, 2)->nullable();
            $table->decimal('boat_depth', 5, 2)->nullable();
            $table->decimal('gross_tonnage', 8, 2)->nullable();
            $table->integer('horsepower')->nullable();
            $table->string('engine_type')->nullable();
            $table->integer('fishermen_count')->nullable();
            
            // Fishing Operation Details
            $table->string('fishing_gear_type')->nullable();
            $table->text('gear_specifications')->nullable();
            $table->integer('hooks_hauls')->nullable();
            $table->decimal('net_line_length', 8, 2)->nullable();
            $table->decimal('soaking_time', 5, 2)->nullable();
            $table->decimal('mesh_size', 5, 2)->nullable();
            $table->integer('days_fished')->nullable();
            $table->string('fishing_location')->nullable();
            $table->string('payao_used')->nullable();
            $table->text('fishing_effort_notes')->nullable();
            
            // Catch Information
            $table->string('catch_type')->nullable();
            $table->decimal('total_catch_kg', 8, 2)->nullable();
            $table->string('subsample_taken')->nullable();
            $table->decimal('subsample_weight', 8, 2)->nullable();
            $table->string('below_legal_size')->nullable();
            $table->string('below_legal_species')->nullable();
            
            // AI Species Recognition & Size Estimation
            $table->string('scientific_name')->nullable();
            $table->string('confidence_score')->nullable();
            $table->string('detection_confidence')->nullable();
            $table->integer('bbox_width')->nullable();
            $table->integer('bbox_height')->nullable();
            $table->decimal('pixels_per_cm', 8, 4)->nullable();
            
            // Additional fields for existing data compatibility
            $table->decimal('latitude', 10, 7)->nullable()->change();
            $table->decimal('longitude', 10, 7)->nullable()->change();
            $table->dateTime('catch_datetime')->nullable()->change();
            $table->string('gear_type')->nullable()->change();
            $table->integer('catch_volume')->nullable()->change();
            $table->text('remarks')->nullable()->change();
            $table->string('image_path')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catches', function (Blueprint $table) {
            // Remove BFAR fields
            $table->dropColumn([
                'region', 'landing_center', 'date_sampling', 'time_landing', 'enumerators',
                'fishing_ground', 'weather_conditions', 'boat_name', 'boat_type', 'boat_length',
                'boat_width', 'boat_depth', 'gross_tonnage', 'horsepower', 'engine_type',
                'fishermen_count', 'fishing_gear_type', 'gear_specifications', 'hooks_hauls',
                'net_line_length', 'soaking_time', 'mesh_size', 'days_fished', 'fishing_location',
                'payao_used', 'fishing_effort_notes', 'catch_type', 'total_catch_kg',
                'subsample_taken', 'subsample_weight', 'below_legal_size', 'below_legal_species',
                'scientific_name', 'confidence_score', 'detection_confidence', 'bbox_width',
                'bbox_height', 'pixels_per_cm'
            ]);
        });
    }
};
