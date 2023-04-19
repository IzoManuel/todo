<?php

use Illuminate\Http\Request;
use Modules\Task\Http\Controllers\TaskUserController;

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

Route::middleware('auth:api')->get('/task', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{id}', [TaskController::class, 'show']);
    Route::post('/tasks/{id}', [TaskController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);

    Route::post('/tasks/{id}/assign', [TaskUserController::class, 'assignTask']);
    Route::post('/tasks/{id}/unassign', [TaskUserController::class, 'unassignTask']);
    Route::post('/tasks/{id}/updateassigned', [TaskUserController::class, 'updateAssignedTask']);
});