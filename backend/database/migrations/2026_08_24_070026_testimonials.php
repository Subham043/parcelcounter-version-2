<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedTinyInteger('star')->default(5)->comment('1 - 5');
            $table->string('designation', 255)->nullable();
            $table->text('message')->nullable();
            $table->string('image', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            
            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'testimonials_is_active_index');
            $table->index(['is_active', 'star'], 'testimonials_active_star_index');
            
            // FullText index for Spatie SearchFilter
            $table->fullText(['name', 'designation', 'message']);

        });
        
        DB::statement("
            ALTER TABLE testimonials
            ADD CONSTRAINT testimonials_star_check
            CHECK (star >= 1 AND star <= 5)
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
