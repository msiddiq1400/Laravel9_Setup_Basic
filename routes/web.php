<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
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

Route::get('/about', function () {
    echo 'this is aabout page';
})->middleware('check');

//categories routes
Route::get('/category/all', [CategoryController::class, 'allCategories'])->name('all.category');
Route::post('/category/add', [CategoryController::class, 'addCategory'])->name('store.category');
Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory']);
Route::get('/category/softDelete/{id}', [CategoryController::class, 'deleteCategory']);
Route::get('/category/restore/{id}', [CategoryController::class, 'restoreCategory']);
Route::get('/category/permanentDelete/{id}', [CategoryController::class, 'permanentDeleteCategory']);
Route::post('/category/update/{id}', [CategoryController::class, 'updateCategory']);

//brand routes
Route::get('/brand/all', [BrandController::class, 'allBrands'])->name('all.brand');
Route::post('/brand/add', [BrandController::class, 'addBrand'])->name('store.brand');
Route::get('/brand/edit/{id}', [BrandController::class, 'editBrand']);
Route::post('/brand/update/{id}', [BrandController::class, 'updateBrand']);
Route::get('/brand/delete/{id}', [BrandController::class, 'deleteBrand']);

//multi image routes
Route::get('/multi/image', [BrandController::class, 'multiImage'])->name('multi.image');
Route::post('/multi/add', [BrandController::class, 'addMultiImage'])->name('store.image');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $users = User::all();
        return view('dashboard', compact('users'));
    })->name('dashboard');
});