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

            $table->index(['name', 'slug'], 'charge_name_slug_index');
            $table->index(['is_active', 'name', 'slug'], 'charge_is_active_name_slug_index');
            $table->index(['is_percentage', 'name', 'slug'], 'charge_is_percentage_name_slug_index');
            $table->index(['is_active', 'is_percentage', 'name', 'slug'], 'charge_is_active_is_percentage_name_slug_index');

            $table->fullText(['name', 'slug']);

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
