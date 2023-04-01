<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\AuthController;
// Route->name('categories.')->group(function(){
// Route::get('/',CategoryController::class,'index');
// Route::get('/',[CategoryController::class,'index'])->name('index');

//Route::get('login.html',AuthController::class,'loginForm')->name('admin.login'); 
Route::get('login.html', [AuthController::class, 'loginForm'])->name('admin.login');
Route::post('login.html', [AuthController::class, 'login'])->name('admin.postLogin');
Route::resource('categories', CategoryController::class);
Route::resource('products', ProductController::class);



Route::get('/', function () {
    return view('admin.dashboard.index');
});
