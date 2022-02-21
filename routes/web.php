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


Auth::routes(['register' => false]);


/*
   BACKEND
*/
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin');
Route::get('/admin/user/list', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin-user-list');
Route::get('/admin/user/form/{id}', [App\Http\Controllers\Admin\UsersController::class, 'create'])->name('admin-user-add');
Route::post('/admin/user/store/{id}', [App\Http\Controllers\Admin\UsersController::class, 'store'])->name('admin-user-store');
Route::get('/admin/user/delete/{id}', [App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('admin-user-del');

Route::post('admin-pages/upload', [App\Http\Controllers\Admin\PageController::class, 'upload'])->name('admin-pages.upload');
Route::post('admin-products/upload', [App\Http\Controllers\Admin\ProductController::class, 'upload'])->name('admin-products.upload');
Route::post('admin-associates/upload', [App\Http\Controllers\Admin\AssociateController::class, 'upload'])->name('admin-associates.upload');

/**
 *   GET/contacts, mapped to the index() method,
 *   GET /contacts/create, mapped to the create() method,
 *   POST /contacts, mapped to the store() method,
 *   GET /contacts/{contact}, mapped to the show() method,
 *   GET /contacts/{contact}/edit, mapped to the edit() method,
 *   PUT/PATCH /contacts/{contact}, mapped to the update() method,
 *   DELETE /contacts/{contact}, mapped to the destroy() method.
 */
Route::resource('admin-pages', App\Http\Controllers\Admin\PageController::class);
Route::resource('admin-products', App\Http\Controllers\Admin\ProductController::class);
Route::resource('admin-associates', App\Http\Controllers\Admin\AssociateController::class);
Route::resource('admin-categories', App\Http\Controllers\Admin\CategoryController::class);
