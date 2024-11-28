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
        Schema::create('sub_status', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('main_status_id');
            $table->foreign('main_status_id')->on('id')->references('status')->onDelete('cascade');
            $table->longText('substatus_name');
            $table->string('slug');
            $table->longText('substatus_remarks')->nullable();
            $table->enum('status',['yes','no']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_status', function (Blueprint $table) {
            $table->dropForeign(['main_status_id']);
        });
        Schema::dropIfExists('sub_status');
    }
};
