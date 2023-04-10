<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EcController;
use App\Http\Controllers\StripePaymentController; 

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
Route::prefix('admin')->group(__DIR__.'/admin.php');
Route::get('/admin', function () {
    return view('admin.dashboard.index');
})->name('dashboard');


// route user 
Route::get('login.html',function(){
    echo'View user login';
});

Route::get('/', [EcController::class, 'index'])->name('index');
// Route::get('/', function () {
//     return view('user.index');
// });

Route::get('/bags',[EcController::class, 'getListBags'])->name('listBags');
Route::get('/bags/{id}',[EcController::class, 'getListBagsOfChildCategory'])->name('listChildBags');

Route::get('/watches',[EcController::class, 'getListWatches'])->name('listWatches');
Route::get('/watches/{id}',[EcController::class, 'getListWatchesOfChildCategory'])->name('listChildWatches');

Route::get('/{id}',[EcController::class, 'getDetailPrd'])->name('detailPrd');
Route::post('/addtocart/{id}',[EcController::class, 'AddToCart'])->name('AddToCart');


Route::get('/cart',function(){
    return view ('user.cart');
});






