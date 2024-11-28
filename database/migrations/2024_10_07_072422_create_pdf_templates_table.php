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
        Schema::create('pdf_templates', function (Blueprint $table) {
            $table->id();
            $table->string('template_name');
            $table->string('template_slug');
            $table->longText('content');
            $table->string('template_logo')->nullable();
            $table->string('template_water_mark')->nullable();
            $table->enum('is_active',['yes','no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pdf_templates');
    }
};