<?php

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

Route::get('/project-comments/{projectId}', [App\Http\Controllers\Api\ProjectCommentController::class, 'index'])->name('project-comments-index');
Route::post('/project-comment', [App\Http\Controllers\Api\ProjectCommentController::class, 'store'])->name('project-comments-store');
Route::delete('/project-comment/{id}', [App\Http\Controllers\Api\ProjectCommentController::class, 'destroy'])->name('project-comments-destroy');
