<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\datatable\DataTableController;


// route for common datatable here
Route::post('admin/datatable/common-datatable',[DataTableController::class,'CommonTable'])->name('admin.common.datatable')->middleware(['auth','verified']);