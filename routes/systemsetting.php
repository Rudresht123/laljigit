<?php

use App\Http\Controllers\systemsetting\EmailTemplateController;
use App\Http\Controllers\systemsetting\EmailConfiguration;
use App\Http\Controllers\systemsetting\FormController;
use Illuminate\Support\Facades\Route;

Route::get('admin_panel/systemsetting/FormField',[FormController::class,'index'])->name('admin.systemsetting.form')->middleware(['auth','verified']);
Route::post('admin_panel/systemsetting/create-FormField',[FormController::class,'store'])->name('admin.systemsetting.create-formfield')->middleware(['auth','verified']);



// Email Template Controller
Route::get('admin_panel/systemsetting/email-all-template',[EmailTemplateController::class,'index'])->middleware(['auth','verified'])->name('admin.systemsetting.all-email-template');
Route::post('admin_panel/systemsetting/create-email-template',[EmailTemplateController::class,'store'])->middleware(['auth','verified'])->name('admin.systemsetting.create-template');
Route::get('admin_panel/systemsetting/create-email-template',[EmailTemplateController::class,'create'])->middleware(['auth','verified'])->name('admin.systemsetting.create-template');
Route::delete('admin_panel/systemsetting/delete-email-template/{id}',[EmailTemplateController::class,'destroy'])->middleware(['auth','verified'])->name('admin.systemsetting.delete-template');
Route::get('admin_panel/systemsetting/edit-email-template/{id}',[EmailTemplateController::class,'edit'])->middleware(['auth','verified'])->name('admin.systemsetting.edit-template');
Route::put('admin_panel/systemsetting/update-email-template/{id}',[EmailTemplateController::class,'update'])->middleware(['auth','verified'])->name('admin.systemsetting.update-template');
Route::get('admin_panel/systemsetting/show-email-template/{id}',[EmailTemplateController::class,'show'])->middleware(['auth','verified'])->name('admin.systemsetting.show-template');


// email EmailConfiguration seting controller start
Route::get('admin_panel/systemsetting/email-configuration',[EmailConfiguration::class,'index'])->middleware(['auth','verified'])->name('admin.systemsetting.update-email-config');
Route::post('admin_panel/systemsetting/update-email-configuration/{id}',[EmailConfiguration::class,'UpdateEmailConfig'])->middleware(['auth','verified'])->name('admin.systemsetting.email-config');

?>