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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('heading', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('description_unfiltered')->nullable();
            $table->string('image', 500)->nullable();
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->text('meta_keywords')->nullable()->comment('comma separated');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Optimized Indexes for Filters & Sorts
            $table->index(['is_active'], 'blogs_is_active_index');
            $table->index(['is_popular'], 'blogs_is_popular_index');

            // FullText index for Spatie SearchFilter
            $table->fullText(['name', 'slug', 'heading', 'description_unfiltered', 'meta_title', 'meta_description', 'meta_keywords'], 'blogs_fulltext');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
