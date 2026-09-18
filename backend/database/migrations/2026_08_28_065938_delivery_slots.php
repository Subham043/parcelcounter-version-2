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

            // Active slots, ordered by start time
            $table->index(
                ['is_active', 'start_time'],
                'delivery_slots_active_start_time_index'
            );

            // Active slots where COD is allowed
            $table->index(
                ['is_active', 'is_cod_allowed', 'start_time'],
                'delivery_slots_active_cod_start_time_index'
            );

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
