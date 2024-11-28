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
        Schema::create('attorneys', function (Blueprint $table) {
            $table->id(); 
            $table->string('attorneys_name');
            $table->string('gender');
            $table->string('email')->unique(); 
            $table->string('phone_number')->unique();
            $table->string('specialization')->nullable(); 
            $table->string('license_number')->unique()->nullable(); 
            $table->date('bar_admission_date')->nullable(); 
            $table->string('profile_picture')->nullable(); 
            $table->text('bio')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attorneys');
    }
};
