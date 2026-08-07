<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/", [LoginController::class, 'login'])->name("login.index");
Route::post("/", [LoginController::class, 'authenticate'])->name("login.authenticate");
Route::post("/logout", [LoginController::class, 'logout'])->name("login.logout");


Route::group(["middleware" => ["auth"]], function () {
    Route::get("/dashboard", [AdminController::class, "index"])->name("admin.index");
    Route::get("/nouvelle-facture", [AdminController::class, "factureIndex"])->name("admin.facture.index");

    
    // Routes pour les factures
    Route::prefix('factures')->name('factures.')->group(function () {
        Route::get('/', [FactureController::class, 'index'])->name('index');
        Route::get('/create', [FactureController::class, 'create'])->name('create');
        Route::post('/', [FactureController::class, 'store'])->name('store');
        Route::get('/{id}', [FactureController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [FactureController::class, 'edit'])->name('edit');
        Route::put('/{id}', [FactureController::class, 'update'])->name('update');
        Route::delete('/{id}', [FactureController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/status', [FactureController::class, 'updateStatus'])->name('status');
        Route::get('/{id}/pdf', [FactureController::class, 'exportPDF'])->name('pdf');
        Route::get('/stats', [FactureController::class, 'getStats'])->name('stats');
        Route::get('/datatable', [FactureController::class, 'getDataTable'])->name('datatable');
    });
});

