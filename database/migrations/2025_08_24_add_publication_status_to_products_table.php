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
        Schema::table('products', function (Blueprint $table) {
            // Add publication status enum field
            $table->enum('publication_status', ['draft', 'published', 'archived'])
                  ->default('draft')
                  ->after('status');
            
            // Add published_at timestamp for tracking when product was published
            $table->timestamp('published_at')->nullable()->after('publication_status');
            
            // Add published_by to track who published the product
            $table->unsignedBigInteger('published_by')->nullable()->after('published_at');
            
            // Add foreign key constraint for published_by
            $table->foreign('published_by')->references('id')->on('users')->onDelete('set null');
            
            // Add index for better query performance
            $table->index(['publication_status', 'published_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['published_by']);
            $table->dropIndex(['publication_status', 'published_at']);
            $table->dropColumn(['publication_status', 'published_at', 'published_by']);
        });
    }
};
