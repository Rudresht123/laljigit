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
        Schema::create('category_form', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on(' main_category')->onDelete('cascade');
            $table->string('field_label'); 
            $table->string('field_name'); 
            $table->enum('field_type', ['text', 'textarea', 'select', 'radio', 'checkbox', 'file', 'date']);
            $table->text('field_options')->nullable(); 
            $table->boolean('is_required')->default(false);
            $table->integer('field_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_form');
    }
};
