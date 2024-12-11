<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExcelMergeController;
use App\Http\Controllers\UserHomeController;
use App\Http\Controllers\GelombangController;
use App\Http\Controllers\HostController;


Route::post('/excel/merge', [ExcelMergeController::class, 'mergeFiles'])->name('excel.merge');
Route::post('/excel/import/{id_gelombang}', [ExcelMergeController::class, 'importFiles'])->name('excel.import');

Route::get('/', [LoginController::class, 'index']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::get('/home', [HomeController::class, 'index']);
Route::get('/nilai', [HomeController::class, 'nilai']);
Route::get('/pimpinan', [HomeController::class, 'pimpinan']);
Route::get('/download/{id_gelombang}', [HomeController::class, 'download'])->name('download');


Route::get('/userhome', [UserHomeController::class, 'index']);
Route::post('/update-detail/{id}', [UserHomeController::class, 'updateDetail'])->name('updateDetail');

Route::post('/gelombang/store', [GelombangController::class, 'store'])->name('gelombang.store');
Route::post('/gelombang/{id_gelombang}', action: [GelombangController::class, 'destroy'])->name('delete.store');
Route::post('/gelombang/{id}/toggle-status', [GelombangController::class, 'toggleStatus'])->name('gelombang.toggleStatus');

Route::get('/host', [HostController::class, 'index']);
