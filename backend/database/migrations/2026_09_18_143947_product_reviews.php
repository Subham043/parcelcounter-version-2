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

            // Main index for active product_review listing
            $table->index(
                ['is_active', 'created_at'],
                'product_reviews_active_created_at_index'
            );

            // Optional: useful if listing/filtering by rating
            $table->index(
                ['is_active', 'rating'],
                'product_reviews_active_star_index'
            );

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
