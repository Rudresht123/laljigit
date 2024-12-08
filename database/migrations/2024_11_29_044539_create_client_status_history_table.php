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
        Schema::create('client_status_history', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id')->unique();
                $table->string('file_name');
                $table->string('email')->unique();
                $table->json('status_history')->nullable(); // To store status details as JSON
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_status_history');
    }
};
