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
        Schema::table('products', function (Blueprint $table) {
            $table->fullText(['name', 'slug', 'meta_keywords'], 'products_global_fulltext');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->fullText(['name', 'slug', 'meta_keywords'], 'categories_global_fulltext');
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->fullText(['name', 'slug', 'meta_keywords'], 'sub_categories_global_fulltext');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropFullText([
                'name',
                'slug',
                'meta_keywords',
            ]);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropFullText([
                'name',
                'slug',
                'meta_keywords',
            ]);
        });

        Schema::table('sub_categories', function (Blueprint $table) {
            $table->dropFullText([
                'name',
                'slug',
                'meta_keywords',
            ]);
        });
    }
};
