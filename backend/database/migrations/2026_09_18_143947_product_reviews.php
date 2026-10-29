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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('rating')->default(5)->comment('1 - 5');
            $table->string('comment', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'product_reviews_is_active_index');
            $table->index(['is_active', 'rating'], 'product_reviews_active_rating_index');
            
            // FullText index for Spatie SearchFilter
            $table->fullText(['comment']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
