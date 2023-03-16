<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
Route::prefix('categories')->name('categories.')->group(function(){
    // Route::get('/',CategoryController::class,'index');
    Route::get('/',[CategoryController::class,'index'])->name('index');
});
Route::get('/', function () {
    return view('admin.dashboard.index');
});