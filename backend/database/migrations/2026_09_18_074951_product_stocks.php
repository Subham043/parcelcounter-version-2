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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedInteger('remaining_quantity')->default(1);
            $table->decimal('purchase_stock', 10, 2)->default(1.00);
            $table->date('purchased_at')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->timestamps();

            // Main index for active feature listing
            $table->index(['created_at', 'id'], 'product_stocks_created_at_id_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};
