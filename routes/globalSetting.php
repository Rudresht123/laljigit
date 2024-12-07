<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\gloalsetting\FinancialYear;
use App\Http\Controllers\gloalsetting\UpdateFinancialYear;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\gloalsetting\AttorneysController;
use App\Http\Controllers\gloalsetting\ClientRemarksController;
use App\Http\Controllers\gloalsetting\MainCategory;
use App\Http\Controllers\gloalsetting\DeallerController;
use App\Http\Controllers\gloalsetting\StatusController;
use App\Http\Controllers\gloalsetting\ConsultantController;
use App\Http\Controllers\OfficesController;
use App\Http\Controllers\SubCategory;
use App\Http\Controllers\gloalsetting\TradeMarksClasses;
use App\Http\Controllers\gloalsetting\ReamrksController;
use App\Http\Controllers\pdf\PDFController;
use App\Http\Controllers\PDFSettingController;
use App\Http\Controllers\SubStatusController;
use App\Http\Controllers\user\RegistrationController;

// Session Controller Start here
Route::get('admin/global-setting/financialYear',[FinancialYear::class,'index'])->name('admin.global-setting.financialYear')->middleware(['auth','verified']);
Route::post('admin/global-setting/financialYear',[FinancialYear::class,'store'])->name('admin.global-setting.financialYear')->middleware(['auth','verified']);
Route::get('admin/global-setting/edit/financialYear/{id}',[FinancialYear::class,'edit'])->name('admin.global-setting.edit.financialYear')->middleware(['auth','verified']);
Route::put('admin/global-setting/edit/financialYear/{id}',[FinancialYear::class,'update'])->name('admin.global-setting.edit.financialYear')->middleware(['auth','verified']);
Route::delete('admin/global-setting/delete/financialYear/{id}',[FinancialYear::class,'destroy'])->name('admin.global-setting.delete.financialYear')->middleware(['auth','verified']);

// Session Update
Route::post('admin/global-setting/update/financialYear/',[UpdateFinancialYear::class,'updateSession'])->name('financialYear.update')->middleware(['auth','verified']);



// Attornyes controller 
Route::get('admin/global-setting/attroneys',[AttorneysController::class,'index'])->name('admin.global-setting.attorneys')->middleware(['auth','verified']);
Route::get('admin/global-setting/create-attroneys',[AttorneysController::class,'create'])->name('admin.global-setting.create.attorneys')->middleware(['auth','verified']);
Route::post('admin/global-setting/create-attroneys',[AttorneysController::class,'store'])->name('admin.global-setting.create.attorneys')->middleware(['auth','verified']);
Route::get('admin/global-setting/edit-attroneys/{id}',[AttorneysController::class,'edit'])->name('admin.global-setting.edit.attorneys')->middleware(['auth','verified']);
Route::put('admin/global-setting/edit-attroneys/{id}',[AttorneysController::class,'update'])->name('admin.global-setting.edit.attorneys')->middleware(['auth','verified']);
Route::delete('admin/global-setting/delete-attroneys/{id}',[AttorneysController::class,'destroy'])->name('admin.global-setting.delete.attorneys')->middleware(['auth','verified']);


// Main category controller start here
Route::get('admin/global-setting.main-category',[MainCategory::class,'index'])->name('admin.global-setting.main-category')->middleware(['auth','verified']);
Route::post('admin/global-setting.create-main-category',[MainCategory::class,'store'])->name('admin.global-setting.create-main-category')->middleware(['auth','verified']);
Route::get('admin/global-setting.edit-main-category/{id}',[MainCategory::class,'edit'])->name('admin.global-setting.edit-main-category')->middleware(['auth','verified']);
Route::put('admin/global-setting.edit-main-category/{id}',[MainCategory::class,'update'])->name('admin.global-setting.edit-main-category')->middleware(['auth','verified']);
Route::delete('admin/global-setting.delete-main-category/{id}',[MainCategory::class,'destroy'])->name('admin.global-setting.delete-main-category')->middleware(['auth','verified']);

// Sub category route start here
Route::get('admin/global-setting/sub-category',[SubCategory::class,'index'])->name('admin.global-setting.sub-category')->middleware(['auth','verified']);
Route::post('admin/global-setting/add/sub-category',[SubCategory::class,'store'])->name('admin.global-setting.create.sub-category')->middleware(['auth','verified']);
Route::get('admin/global-setting/show/sub-category',[SubCategory::class,'create'])->name('admin.global-setting.show-sub-category')->middleware(['auth','verified']);
Route::get('admin/global-setting/show-sub-category/{id}',[SubCategory::class,'show'])->name('admin.global-setting.show.sub-category')->middleware(['auth','verified']);
Route::get('admin/global-setting/edit-sub-category/{id}',[SubCategory::class,'edit'])->name('admin.global-setting.edit.sub-category')->middleware(['auth','verified']);
Route::put('admin/global-setting/update-sub-category/{id}',[SubCategory::class,'update'])->name('admin.global-setting.update.sub-category')->middleware(['auth','verified']);
Route::delete('admin/global-setting/delete-sub-category/{id}',[SubCategory::class,'destroy'])->name('admin.global-setting.delete.sub-category')->middleware(['auth','verified']);


// Status controller start here
Route::get('admin/global_setting/status',[StatusController::class,'index'])->name('admin.global-setting.status')->middleware(['auth','verified']);
Route::post('admin/global_setting/create-status',[StatusController::class,'store'])->name('admin.global-setting.create-status')->middleware(['auth','verified']);
Route::get('admin/global_setting/edit-status/{id}',[StatusController::class,'edit'])->name('admin.global-setting.edit-status')->middleware(['auth','verified']);
Route::put('admin/global_setting/edit-status/{id}',[StatusController::class,'update'])->name('admin.global-setting.edit-status')->middleware(['auth','verified']);
Route::delete('admin/global_setting/delete-status/{id}',[StatusController::class,'destroy'])->name('admin.global-setting.delete-status')->middleware(['auth','verified']);


// dealler status Controller
Route::get('admin/global_setting/consultant',[ConsultantController::class,'index'])->name('admin.global-setting.consultant')->middleware(['auth','verified']);
Route::post('admin/global_setting/consultant',[ConsultantController::class,'store'])->name('admin.global-setting.create-consultant')->middleware(['auth','verified']);
Route::get('admin/global_setting/consultant/{id}',[ConsultantController::class,'edit'])->name('admin.global-setting.edit-consultant')->middleware(['auth','verified']);
Route::put('admin/global_setting/consultant/{id}',[ConsultantController::class,'update'])->name('admin.global-setting.update-consultant')->middleware(['auth','verified']);
Route::delete('admin/global_setting/consultant/{id}',[ConsultantController::class,'destroy'])->name('admin.global-setting.destroy-consultant')->middleware(['auth','verified']);



// Dealler COntroller Start Here

Route::get('admin/global_setting/dealler',[DeallerController::class,'index'])->name('admin.global-setting.dealler')->middleware(['auth','verified']);
Route::post('admin/global_setting/dealler',[DeallerController::class,'store'])->name('admin.global-setting.create-dealler')->middleware(['auth','verified']);
Route::get('admin/global_setting/dealler/{id}',[DeallerController::class,'edit'])->name('admin.global-setting.edit-dealler')->middleware(['auth','verified']);
Route::put('admin/global_setting/dealler/{id}',[DeallerController::class,'update'])->name('admin.global-setting.update-dealler')->middleware(['auth','verified']);
Route::delete('admin/global_setting/dealler/{id}',[DeallerController::class,'destroy'])->name('admin.global-setting.destroy-dealler')->middleware(['auth','verified']);



// Sub status controller start here
Route::get('admin/global_setting/sub-status',[SubStatusController::class,'index'])->name('admin.global-setting.sub-status')->middleware(['auth','verified']);
Route::get('admin/global_setting/create-sub-status',[SubStatusController::class,'create'])->name('admin.global-setting.create-sub-status')->middleware(['auth','verified']);
Route::post('admin/global_setting/create-sub-status',[SubStatusController::class,'store'])->name('admin.global-setting.store-sub-status')->middleware(['auth','verified']);
Route::get('admin/global_setting/show-sub-status/{statusid}',[SubStatusController::class,'show'])->name('admin.global-setting.show-sub-status')->middleware(['auth','verified']);
Route::get('admin/global_setting/edit-sub-status/{statusid}',[SubStatusController::class,'edit'])->name('admin.global-setting.edit-sub-status')->middleware(['auth','verified']);
Route::put('admin/global_setting/edit-sub-status/{statusid}',[SubStatusController::class,'update'])->name('admin.global-setting.update-sub-status')->middleware(['auth','verified']);
Route::delete('admin/global_setting/delete-sub-status/{statusid}',[SubStatusController::class,'destroy'])->name('admin.global-setting.destroy-sub-status')->middleware(['auth','verified']);



// Office Controller start here
Route::get('admin/global_setting/offices',[OfficesController::class,'index'])->name('admin.global_setting.office')->middleware(['auth','verified']);
Route::post('admin/global_setting/offices/create-office',[OfficesController::class,'store'])->name('admin.global_setting.create-office')->middleware(['auth','verified']);
Route::get('admin/global_setting/offices/edit-office/{id}',[OfficesController::class,'edit'])->name('admin.global_setting.edit-office')->middleware(['auth','verified']);
Route::put('admin/global_setting/offices/edit-office/{id}',[OfficesController::class,'update'])->name('admin.global_setting.edit-office')->middleware(['auth','verified']);
Route::delete('admin/global_setting/offices/delete-office/{id}',[OfficesController::class,'destroy'])->name('admin.global_setting.delete-office')->middleware(['auth','verified']);


// Trademark Classes Controller start here
Route::get('admin/global_setting/trademark-classes',[TradeMarksClasses::class,'TrademarkClass'])->name('admin.global-setting.trademark-classes')->middleware(['auth','verified']);

// User Registration Controller
Route::get('admin/attorney/category/{id}',[RegistrationController::class,'showAttorneyCatgory'])->name('admin.attorney.show-category')->middleware(['auth','verified']);
Route::get('admin/attorney/category/{attoernyId}/{category}',[RegistrationController::class,'registrationForm'])->name('admin.attorney.user-registration')->middleware(['auth','verified']);
Route::post('admin/attorney/category/addTrademarkFormData',[RegistrationController::class,'addTrademarkUserForm'])->name('admin.attorney.addtrademarkformdata')->middleware(['auth','verified']);
Route::post('admin/attorney/category/updateTrademarkFormData/{application_no}',[RegistrationController::class,'updateClientDetails'])->name('admin.attorney.updatetrademarkformdata')->middleware(['auth','verified']);
Route::get('admin/attorney/category/client-details/category/{category_slug}/application_no/{application_no}', [RegistrationController::class, 'clientsDetails'])->name('admin.attorney.clientDetails')->middleware(['auth', 'verified']);
Route::get('admin/attorney/{attoerny_id}/category/edit-client-details/category/{category_slug}/application_no/{application_no}', [RegistrationController::class, 'editClientDetails'])->name('admin.attorney.edit-clientDetails')->middleware(['auth', 'verified']);



// Remarks controller start here
Route::get('admin/global_setting/remarks',[ReamrksController::class,'index'])->name('admin.global-setting.remarks')->middleware(['auth','verified']);
Route::post('admin/global_setting/create-remarks',[ReamrksController::class,'store'])->name('admin.global-setting.create-remarks')->middleware(['auth','verified']);
Route::get('admin/global_setting/edit-remarks/{id}',[ReamrksController::class,'edit'])->name('admin.global-setting.edit-remarks')->middleware(['auth','verified']);
Route::put('admin/global_setting/edit-remarks/{id}',[ReamrksController::class,'update'])->name('admin.global-setting.edit-remarks')->middleware(['auth','verified']);
Route::delete('admin/global_setting/delete-remarks/{id}',[ReamrksController::class,'destroy'])->name('admin.global-setting.delete-remarks')->middleware(['auth','verified']);


// Clent Remarks Controller
Route::get('admin/global_setting/cleint-remarks',[ClientRemarksController::class,'index'])->name('admin.global-setting.client-remarks')->middleware(['auth','verified']);
Route::post('admin/global_setting/create-client-remarks',[ClientRemarksController::class,'store'])->name('admin.global-setting.create-client-remarks')->middleware(['auth','verified']);
Route::get('admin/global_setting/edit-client-remarks/{id}',[ClientRemarksController::class,'edit'])->name('admin.global-setting.edit-client-remarks')->middleware(['auth','verified']);
Route::put('admin/global_setting/edit-client-remarks/{id}',[ClientRemarksController::class,'update'])->name('admin.global-setting.update-client-remarks')->middleware(['auth','verified']);
Route::delete('admin/global_setting/delete-client-remarks/{id}',[ClientRemarksController::class,'destroy'])->name('admin.global-setting.delete-client-remarks')->middleware(['auth','verified']);


// Pdf Controller start here
Route::get('admin/global_setting/pdf-template',[PDFSettingController::class,'index'])->name('admin.global-setting.pdf-template')->middleware(['auth','verified']);
Route::get('admin/global_setting/create-pdf-template',[PDFSettingController::class,'create'])->name('admin.global-setting.create-pdf-template')->middleware(['auth','verified']);
Route::post('admin/global_setting/create-pdf-template',[PDFSettingController::class,'store'])->name('admin.global-setting.create-pdf-template')->middleware(['auth','verified']);
Route::get('admin/global_setting/edit-pdf-template/{id}',[PDFSettingController::class,'edit'])->name('admin.global-setting.edit-pdf-template')->middleware(['auth','verified']);
Route::put('admin/global_setting/edit-pdf-template/{id}',[PDFSettingController::class,'update'])->name('admin.global-setting.edit-pdf-template')->middleware(['auth','verified']);
Route::delete('admin/global_setting/delete-pdf-template/{id}',[PDFSettingController::class,'destroy'])->name('admin.global-setting.delete-pdf-template')->middleware(['auth','verified']);



// Pdf Controllers Method
Route::get('admin/TrademarkUser/pdf/{id}', [PDFController::class, 'generatePDF'])->name('admin.trademarkuser.pdf')->middleware(['auth','verified']);