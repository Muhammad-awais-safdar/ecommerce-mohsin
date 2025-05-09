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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
    $table->string('session_id');
    $table->foreignId('product_id')->constrained()->onDelete('cascade');
    $table->decimal('offered_price', 10, 2);
    $table->string('contact_info');
    $table->enum('status', ['pending','accepted','rejected','countered'])->default('pending');
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
