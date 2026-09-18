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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255)->unique();
            $table->string('hsn', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('description_unfiltered')->nullable();
            $table->string('brief_description', 500)->nullable();
            $table->string('image', 500)->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('min_cart_quantity')->default(1);
            $table->unsignedInteger('cart_quantity_interval')->default(1);
            $table->string('cart_quantity_specification', 255)->default('pieces');
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->text('meta_keywords')->nullable()->comment('comma separated');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['name', 'slug'], 'products_name_slug_index');
            $table->index(['is_active', 'name', 'slug'], 'products_is_active_name_slug_index');

            $table->fullText(['name', 'slug', 'hsn', 'description_unfiltered', 'brief_description', 'meta_title', 'meta_description', 'meta_keywords'], 'products_fulltext');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
