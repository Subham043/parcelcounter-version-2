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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->string('image', 500)->nullable();
            $table->string('image_title', 255)->nullable();
            $table->string('image_alt', 255)->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamps();

            // Main index for active feature listing
            $table->index(['created_at', 'id'], 'product_images_created_at_id_index');

            $table->fullText(['image_title', 'image_alt'], 'product_images_fulltext_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
