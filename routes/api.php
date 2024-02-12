<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PagesApiController;

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

// Unauthorized Route
Route::post('/sign-up', [AuthController::class, 'signUp']);
Route::post('/user-login', [AuthController::class, 'UserLogin']);
Route::get('/privacy-policy', [PagesApiController::class, 'PrivacyPolicy']);
Route::get('/terms-and-conditions', [PagesApiController::class, 'TermsandConditions']);

// Authorized Route
Route::group(['middleware'=>'auth:sanctum'], function(){

    Route::post('/logout', [AuthController::class, 'UserLogout']);
    Route::get('/user-detail', [AuthController::class, 'UserDetail']);
    Route::post('/user-profile-update', [AuthController::class, 'UserProfileUpdate']);
});


