<?php

use App\Http\Controllers\excels\ExcelsImport;
use App\Http\Controllers\pdf\PrintPdfController;
use App\Http\Controllers\reports\ClientsReports;
use Illuminate\Support\Facades\Route;


// reports controller start here
Route::get('admin_panel/reports/client-reports',[ClientsReports::class,'Clients'])->name('admin.reports.clients-reports')->middleware(['auth','verified']);


// Excels Import Controller
Route::post('admin/excels-import/clients-import',[ExcelsImport::class,'ClientsImport'])->name('admin.excels-import.clients-import')->middleware(['auth','verified']);
Route::post('admin/excels-export/clients-export',[ExcelsImport::class,'ClientsExcelExport'])->name('admin.excels-import.clients-export')->middleware(['auth','verified']);


// Pdf Print
Route::get('admin/print-client-details/category_slug/{category_slug}/application_no/{application_no}',[PrintPdfController::class,'printClientPdf'])->name('admin.client-details.print-pdf')->middleware(['auth','verified']);