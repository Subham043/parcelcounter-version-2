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
        Schema::create('contact_form_enquiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255)->nullable();
            $table->string('subject', 255)->nullable();
            $table->string('message', 500)->nullable();
            $table->string('page_url', 500)->nullable();
            $table->timestamps();

            // Main index for active feature listing
            $table->index(['name', 'id'], 'contact_form_enquiries_name_id_index');
            $table->index(['created_at', 'id'], 'contact_form_enquiries_created_at_id_index');

            $table->fullText(['name', 'email', 'phone', 'page_url', 'subject', 'message'], 'contact_form_enquiries_fulltext_index');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_form_enquiries');
    }
};
