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
        Schema::create('sub_category', function (Blueprint $table) {
            $table->id();
            $table->string('subcategory');
            $table->longText('subcategory_remark')->nullable();
            $table->bigInteger('main_category_id');
            $table->foreign('main_category_id') 
            ->references('id')         
            ->on('main_category')     
            ->onDelete('cascade');  
            $table->enum('status',['yes','no'])->default('yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_category');
    }
};
