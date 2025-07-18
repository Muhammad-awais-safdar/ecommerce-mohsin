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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();

            // Perfume-specific fields
            $table->string('gender')->nullable(); // male, female, unisex
            $table->string('fragrance_type')->nullable(); // floral, woody, citrus
            $table->string('concentration')->nullable(); // EDP, EDT, Parfum
            $table->string('top_notes')->nullable();
            $table->string('middle_notes')->nullable();
            $table->string('base_notes')->nullable();
            $table->integer('volume_ml')->nullable(); // bottle size in ml
            $table->integer('longevity_hours')->nullable(); // estimated longevity
            $table->string('country_of_origin')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
