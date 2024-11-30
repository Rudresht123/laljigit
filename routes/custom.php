<?php

use App\Http\Controllers\Chart\ChartController;
use App\Http\Controllers\reports\StatusHistoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Controllers\CustomFunctions;

// Session Update
Route::get('admin/global-setting/custom-functions/getSubstatus/{id}',[CustomFunctions::class,'getSubStatus'])->name('getsubstatus')->middleware(['auth','verified']);
Route::post('admin/global-setting/custom-functions/getFillterdata',[CustomFunctions::class,'getClients'])->name('admin.getFiellterClientsData')->middleware(['auth','verified']);
Route::post('admin/clients-reporst/custom-functions/getClientDetailsForUpdateStatus',[CustomFunctions::class,'getClientDetailsForUpdateStatus'])->name('admin.getClientDataForUpdate')->middleware(['auth','verified']);
Route::post('admin/clients-reporst/custom-functions/updateclient-status',[CustomFunctions::class,'UpdateClientStatus'])->name('admin.UpdateClientStatus')->middleware(['auth','verified']);
Route::post('admin/clients-reporst/custom-functions/getClients',[CustomFunctions::class,'getClients'])->name('admin.getFiellterClientsData')->middleware(['auth','verified']);




// chart controller routes start here
Route::get('/admin/chart/CategoryWiseUserCount',[ChartController::class,'categoryWiseClientChart'])->name('admin.chart.CategoryWiseUserCount')->middleware(['auth','verified']);
Route::get('/admin/chart/StatusWiseClientCount',[ChartController::class,'statusWisewiseClientChart'])->name('admin.chart.statusWiseClientChart')->middleware(['auth','verified']);




// Route for the get search client on the dashboar
Route::post('/admin/get/search_cleint',[CustomFunctions::class,'searchCleint'])->name('get.searchClent')->middleware(['auth','verified']);
Route::post('/admin/get/search-cleint-details',[CustomFunctions::class,'searchClientDetails'])->name('get.searchClent-detail-dashboard')->middleware(['auth','verified']);


// Status History Column start here
ROute::get('admin/client/status-history/{application_no}',[StatusHistoryController::class,'getStatusHistory'])->name('admin.status.client-status')->middleware(['auth','verified']);