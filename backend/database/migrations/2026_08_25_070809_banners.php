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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('alt', 255)->nullable();
            $table->string('desktop_image', 500)->nullable();
            $table->string('mobile_image', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'banners_is_active_index');

            // FullText index for Spatie SearchFilter
            $table->fullText(['title', 'alt']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
