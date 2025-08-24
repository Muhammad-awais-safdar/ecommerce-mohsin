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
        Schema::create('login_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('ip_address');
            $table->string('location')->nullable();
            $table->string('isp')->nullable();
            $table->string('platform')->nullable();     // e.g., Windows, iOS
            $table->string('device_type')->nullable();  // mobile / tablet / desktop
            $table->string('browser')->nullable();      // Chrome, Firefox, etc.
            $table->string('user_agent');               // full user agent string
            $table->string('session_hash');             // to group unique sessions
            $table->boolean('is_notified')->default(false); // for IP/location notification
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_activities');
    }
};
