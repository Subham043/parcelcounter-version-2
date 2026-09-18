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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->string('name', 255);
            $table->decimal('value', 10, 2)->default(0.00);
            $table->boolean('is_inter_state_tax')->default(false);
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['name', 'slug'], 'taxes_name_slug_index');
            $table->index(['is_active', 'name', 'slug'], 'taxes_is_active_name_slug_index');
            $table->index(['is_inter_state_tax', 'name', 'slug'], 'taxes_inter_state_tax_name_slug_index');
            $table->index(['is_active', 'is_inter_state_tax', 'name', 'slug'], 'taxes_is_active_inter_state_tax_name_slug_index');

            $table->fullText(['name', 'slug']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
