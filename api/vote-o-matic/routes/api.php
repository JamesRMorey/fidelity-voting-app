<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\VoteController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/random-question', [QuestionController::class, 'random'])->name('question.random');
    Route:: post('/question/{question}/vote', [VoteController::class, 'store'])->middleware('user-has-not-voted')->name('vote.store');
});
