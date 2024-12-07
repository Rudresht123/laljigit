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
        Schema::create('trademark_users', function (Blueprint $table) {
            $table->id();
            
            // Attorney and Category relationships
            $table->unsignedBigInteger('attorney_id');
            $table->foreign('attorney_id')
                  ->references('id')
                  ->on('attorneys')
                  ->onDelete('restrict');
            
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                  ->references('id')
                  ->on('main_category')
                  ->onDelete('restrict');
            
            // Office relationship
            $table->unsignedBigInteger('office_id')->nullable();
            $table->foreign('office_id')
                  ->references('id')
                  ->on('offices')
                  ->onDelete('restrict');
            
            // Trademark-related fields
            $table->bigInteger('application_no')->nullable();
            $table->string('file_name')->nullable();
            $table->string('trademark_name')->nullable();
            $table->unsignedBigInteger('trademark_class')->nullable();
            $table->date('filling_date')->nullable();
            $table->bigInteger('phone_no')->nullable();
            $table->string('email_id')->nullable();
            $table->date('date_of_application')->nullable();
            $table->date('opposition_hearing_date')->nullable();
            
            // Status and Sub-status relationships
            $table->unsignedBigInteger('status')->nullable();
            $table->foreign('status')
                  ->references('id')
                  ->on('status')
                  ->onDelete('restrict');
            
            $table->unsignedBigInteger('sub_status')->nullable();
            $table->foreign('sub_status')
                  ->references('id')
                  ->on('sub_status')
                  ->onDelete('restrict');
            
            // Remarks relationship
            $table->unsignedBigInteger('remarks')->nullable();
            $table->foreign('remarks')
                  ->references('id')
                  ->on('remarks')
                  ->onDelete('restrict')->nullable();
            
            // Consultant relationship
            $table->unsignedBigInteger('consultant');
            $table->foreign('consultant')
                  ->references('id')
                  ->on('consultant')
                  ->onDelete('restrict');
            
            // Dynamic fields (Add the dynamic fields you need)
            $table->date('objected_hearing_date')->nullable();
            $table->string('opponenet_applicant_name')->nullable();
            $table->string('opponent_applicant')->nullable();
            $table->string('opponent_applicant_code')->nullable();
            $table->date('hearing_date')->nullable();
            $table->string('rectification_no')->nullable();
            $table->string('opposed_no')->nullable();
            $table->string('examination_report')->nullable();
            
            // Deal With relationship
            $table->unsignedBigInteger('deal_with')->nullable();
            $table->foreign('deal_with')
                  ->references('id')
                  ->on('deal_with')
                  ->onDelete('restrict');
            
            // Sub Category relationship
            $table->unsignedBigInteger('sub_category');
            $table->foreign('sub_category')
                  ->references('id')
                  ->on('sub_category')
                  ->onDelete('restrict');
            
            // Validity date and filed by
            $table->date('valid_up_to')->nullable();
            $table->string('filed_by')->nullable();
            
            // Financial Year relationship
            $table->bigInteger('financial_year');
            $table->foreign('financial_year')
                  ->references('id')
                  ->on('financial_year')
                  ->onDelete('restrict');
            
            $table->timestamps();
            
            // Miscellaneous fields
            $table->string('opposition_no')->nullable();
            $table->text('post_hearing_remarks')->nullable();
            $table->string('ip_field')->nullable();
            $table->date('evidence_last_date')->nullable();
            $table->string('email_remarks')->nullable();
            $table->string('client_communication')->nullable();
            $table->date('mail_recived_date')->nullable(); // Only keep one mail received date
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trademark_users');
    }
};
