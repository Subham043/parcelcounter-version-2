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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 255)->unique();
            $table->string('name', 255);
            $table->decimal('value', 10, 2)->default(0.00);
            $table->boolean('is_percentage')->default(false);
            $table->decimal('include_charges_for_cart_price_below', 10, 2)->default(0.00)->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            // Optimized Indexes for Filters & Sorts
            $table->index('is_active', 'charges_is_active_index');
            $table->index('is_percentage', 'charges_is_percentage_index');
            
            // FullText index for Spatie SearchFilter
            $table->fullText(['name', 'slug'], 'charges_name_slug_fulltext');

        });
        
        DB::statement("
            ALTER TABLE charges
            ADD CONSTRAINT charges_percentage_value_check
            CHECK (
                is_percentage = 0
                OR value <= 100
            )
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
