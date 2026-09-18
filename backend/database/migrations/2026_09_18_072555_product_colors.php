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
        Schema::create('product_colors', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('code', 255)->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamps();

            // Main index for active feature listing
            $table->index(['name', 'id'], 'product_colors_name_id_index');
            $table->index(['created_at', 'id'], 'product_colors_created_at_id_index');

            $table->fullText(['name', 'code'], 'product_colors_fulltext_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_colors');
    }
};
