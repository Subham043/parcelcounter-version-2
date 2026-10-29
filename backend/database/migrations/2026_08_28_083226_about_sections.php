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
        Schema::create('about_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading', 255);
            $table->text('description')->nullable();
            $table->text('description_unfiltered')->nullable();
            $table->string('image', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'about_sections_is_active_index');
            
            // FullText index for Spatie SearchFilter
            $table->fullText(['heading', 'description_unfiltered'], 'about_sections_fulltext');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_sections');
    }
};
