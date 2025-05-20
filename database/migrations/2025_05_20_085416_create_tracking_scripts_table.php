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
        Schema::create('tracking_scripts', function (Blueprint $table) {
            $table->id();
        $table->string('name'); // e.g. Google Analytics, Meta Pixel
        $table->enum('location', ['head', 'body_end'])->default('head'); // where to inject
        $table->text('script'); // the actual JS/HTML
        $table->boolean('is_active')->default(true); // toggle
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_scripts');
    }
};
