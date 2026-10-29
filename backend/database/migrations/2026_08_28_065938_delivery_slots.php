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
        Schema::create('delivery_slots', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_cod_allowed')->default(true);
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            
            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'delivery_slots_is_active_index');
            $table->index('is_cod_allowed', 'delivery_slots_is_cod_allowed_index');
            $table->index(
                ['is_active', 'start_time'],
                'delivery_slots_active_start_time_index'
            );
            
            // FullText index for Spatie SearchFilter
            $table->fullText(['name']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_slots');
    }
};
