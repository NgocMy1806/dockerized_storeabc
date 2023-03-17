<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
// Route->name('categories.')->group(function(){
    // Route::get('/',CategoryController::class,'index');
   // Route::get('/',[CategoryController::class,'index'])->name('index');
    Route::resource('categories', CategoryController::class);
// });
Route::get('/', function () {
    return view('admin.dashboard.index');
});