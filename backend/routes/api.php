<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/product',[ProductController::class,'index']);
Route::post('/product_store',[ProductController::class,'store']);
Route::delete('/product_delete/{product}',[ProductController::class,'destroy']);
Route::get('/product_show/{product}',[ProductController::class,'show']);
Route::put('/product_update/{product}',[ProductController::class,'update']);
Route::get('/product_search/{data}',[ProductController::class,'search']);