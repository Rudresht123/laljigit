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
        Schema::create('main_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name');
            $table->longText('remark')->nullable();
            $table->string('category_slug');
            $table->string('category_icon')->nullable();
            $table->enum('status',['yes','no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_category');
    }
};
