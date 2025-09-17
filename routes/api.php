<?php

use App\Http\Controllers\Category\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('/categories',[CategoryController::class,'index']);
Route::post('/categories',[CategoryController::class,'store']);
Route::get('/categories/{term}',[CategoryController::class,'show']);
Route::put('/categories/{id}',[CategoryController::class,'update']);
Route::delete('/categories/{id}',[CategoryController::class,'destroy']);