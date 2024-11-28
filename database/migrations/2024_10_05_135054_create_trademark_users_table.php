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
            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')
            ->references('id')
            ->on('offices')
            ->onDelete('restrict');
            $table->bigInteger('application_no');
            $table->string('file_name');
            $table->string('trademark_name');
            $table->unsignedBigInteger('trademark_class');
            $table->date('filling_date');
            $table->bigInteger('phone_no')->nullable();
            $table->string('email_id')->nullable();
            $table->date('date_of_application');
            $table->date('objected_hearing_date')->nullable();
            $table->string('opponenet_applicant_name')->nullable();
            $table->date('opposition_hearing_date')->nullable();
            $table->unsignedBigInteger('status');
           
           
            $table->foreign('status')
            ->references('id')
            ->on('status')
            ->onDelete('restrict');
            $table->unsignedBigInteger('sub_status');
            $table->foreign('sub_status')
            ->references('id')
            ->on('sub_status')
            ->onDelete('restrict');
            $table->unsignedBigInteger('client_remarks');
            $table->foreign('client_remarks')
            ->references('id')
            ->on('client_remarks')
            ->onDelete('restrict');
            $table->unsignedBigInteger('remarks');
            $table->foreign('remarks')
            ->references('id')
            ->on('remarks')
            ->onDelete('restrict');
            $table->unsignedBigInteger('consultant');
            $table->foreign('consultant')
            ->references('id')
            ->on('consultant')
            ->onDelete('restrict');


            $table->unsignedBigInteger('deal_with');
            $table->foreign('deal_with')
            ->references('id')
            ->on('deal_with')
            ->onDelete('restrict');


            $table->unsignedBigInteger('sub_category');
            $table->foreign('sub_category')
            ->references('id')
            ->on('sub_category')
            ->onDelete('restrict');
            
            $table->date('valid_up_to')->nullable();
            $table->string('deal_with')->nullable();
            $table->string('filed_by')->nullable();
            $table->unsignedBigInteger('client_remarks');
            $table->foreign('client_remarks')
            ->references('id')
            ->on('client_remarks')
            ->onDelete('restrict');
            $table->unsignedBigInteger('remarks');
            $table->foreign('remarks')
            ->references('id')
            ->on('remarks')
            ->onDelete('restrict');
            $table->bigInteger('financial_year');
            $table->foreign('financial_year')
            ->references('id')
            ->on('financial_year')
            ->onDelete('restrict');
            $table->timestamps();

            $table->string('ip_field')->nullable();
            $table->date('evidence_last_date')->nullable();
            $table->string('email_remarks')->nullable();
            $table->string('client_communication')->nullable();
            $table->date('mail_recived_date')->nullable();
            $table->date('mail_recived_date_2')->nullable();


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
