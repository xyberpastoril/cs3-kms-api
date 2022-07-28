<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth Classes
use App\Http\Controllers\Api\Auth\AuthenticationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\RegisterController;

// Core Classes
use App\Http\Controllers\Api\Core\QuestionController;
use App\Http\Controllers\Api\Core\AnswerController;
use App\Http\Controllers\Api\Core\CategoryController;
use App\Http\Controllers\Api\Core\WaitlistController;

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

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout'])->middleware('auth:api');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgot']);
Route::post('/reset-password', [ForgotPasswordController::class, 'reset']);

Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'search');
    Route::group(['prefix' => '/question'], function() {
        Route::post('/', 'store');
        Route::get('/{question}/{update_token?}', 'show');
        Route::put('/{question}/{update_token?}', 'update');
        Route::delete('/{question}/{update_token?}', 'destroy');
        Route::patch('/{question}', 'restore');
    });
});

Route::controller(AnswerController::class)->group(function () {
    Route::group(['prefix' => '/answer'], function() {
        Route::post('/{question}', 'store');
        Route::delete('/{question}/{answer}', 'destroy');
    });
});

Route::controller(WaitlistController::class)->group(function () {
    Route::group(['prefix' => '/waitlist'], function() {
        Route::post('/{question}', 'store');
        Route::delete('/{question}/{waitlister}', 'destroy');
    });
});