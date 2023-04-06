<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('user.hp');
});
// Route::middleware(['userAuth:user'])->group(function () {
//     Route::resource('categories', CategoryController::class);
//     Route::resource('products', ProductController::class);
//     // Route::resource('tags', TagController::class);
//     Route::prefix('tags')->name('tags.')->group(function(){
//         Route::get('search',[TagController::class,'searchTagByKey']);
//     });
//     Route::get('/', function () {
//         return view('admin.dashboard.index');
//     });
// });