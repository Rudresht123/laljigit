<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboard\DashboardController;


require_once('globalSetting.php');
require_once('systemsetting.php');
require_once('custom.php');
require_once('reports.php');
require_once('datatable.php');


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
