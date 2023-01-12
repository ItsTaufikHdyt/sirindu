<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
// Route::middleware(['auth', "prefix" => "user/", 'user-access:user'])->group(function () {
//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// });

/*------------------------------------------
--------------------------------------------
All Super Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:super-admin'])->prefix('super-admin/')->group(function () {
    Route::get('home', [App\Http\Controllers\AdminController::class, 'superAdminHome'])->name('super.admin.home');
    //User Route List
    Route::get('user', [App\Http\Controllers\AdminController::class, 'user'])->name('super.admin.user');
    Route::post('store-user', [App\Http\Controllers\AdminController::class, 'storeUser'])->name('super.admin.storeUser');
    Route::put('update-user/{id}', [App\Http\Controllers\AdminController::class, 'updateUser'])->name('super.admin.updateUser');
    Route::delete('delete-user/{id}', [App\Http\Controllers\AdminController::class, 'destroyUser'])->name('super.admin.destroyUser');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/

Route::middleware(['auth', 'is_admin'])->prefix('admin/')->group(function () {
    Route::get('home', [App\Http\Controllers\AdminController::class, 'adminHome'])->name('admin.home');
    //Anak Route List
    Route::get('data-dasar-anak', [App\Http\Controllers\AdminController::class, 'anak'])->name('admin.anak');
    Route::get('get-data-dasar-anak', [App\Http\Controllers\AdminController::class, 'getAnak'])->name('admin.getAnak');
    Route::get('create-data-dasar-anak', [App\Http\Controllers\AdminController::class, 'createAnak'])->name('admin.createAnak');
    Route::get('get-kel-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getKelAnak'])->name('admin.getKelAnak');
    Route::get('get-puskesmas-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getPuskesmasAnak'])->name('admin.getPuskesmasAnak');
    Route::get('get-posyandu-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getPosyanduAnak'])->name('admin.getPosyanduAnak');
    Route::get('get-rt-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getRtAnak'])->name('admin.getRtAnak');
    Route::get('get-posyandu-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getPosyanduAnak'])->name('admin.getPosyanduAnak');
    Route::post('store-data-dasar-anak', [App\Http\Controllers\AdminController::class, 'storeAnak'])->name('admin.storeAnak');
    Route::get('edit-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'editAnak'])->name('admin.editAnak');
    Route::get('show-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'showAnak'])->name('admin.showAnak');
    Route::get('chart-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'chartAnak'])->name('admin.chartAnak');
    Route::get('get-chart-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'getChartAnak'])->name('admin.getChartAnak');
    Route::put('update-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'updateAnak'])->name('admin.updateAnak');
    Route::delete('destroy-data-dasar-anak/{id}', [App\Http\Controllers\AdminController::class, 'destroyAnak'])->name('admin.destroyAnak');
    //Data Anak Route List
    Route::get('data-anak/{id}', [App\Http\Controllers\AdminController::class, 'dataAnak'])->name('admin.dataAnak');
    Route::post('store-data-anak', [App\Http\Controllers\AdminController::class, 'storeDataAnak'])->name('admin.storeDataAnak');
    Route::put('update-data-anak/{id}', [App\Http\Controllers\AdminController::class, 'updateDataAnak'])->name('admin.updateDataAnak');
    Route::get('edit-data-anak/{id}', [App\Http\Controllers\AdminController::class, 'editDataAnak'])->name('admin.editDataAnak');
    //Ibu Route List
    Route::get('data-ibu', [App\Http\Controllers\AdminController::class, 'ibu'])->name('admin.ibu');
    //Ibu Hamil Route List
    Route::get('data-ibu-hamil', [App\Http\Controllers\AdminController::class, 'ibuHamil'])->name('admin.ibuHamil');
});
