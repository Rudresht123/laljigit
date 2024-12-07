<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;
use Illuminate\Support\Facades\Artisan;

require_once('globalSetting.php');
require_once('systemsetting.php');
require_once('custom.php');
require_once('reports.php');
require_once('datatable.php');



Route::get('/run-storage-link', function () {
    try {
        Artisan::call('storage:link');
        return "The storage link has been created successfully!";
    } catch (Exception $e) {
        return "An error occurred while creating the storage link: " . $e->getMessage();
    }
});

Route::get('/clear-all-caches', function () {
    try {
        // Clear Cache
        // Artisan::call('cache:clear');
        // // Clear Config Cache
        // Artisan::call('config:clear');
        // Clear Route Cache
        Artisan::call('route:clear');
        // // Clear View Cache
        // Artisan::call('view:clear');
        //  Artisan::call('optimize');
         

        return response()->json([
            'message' => 'All caches cleared successfully!'
        ]);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'An error occurred while clearing caches.',
            'error' => $e->getMessage(),
        ], 500);
    }
});



Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('admin/dashboard',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
