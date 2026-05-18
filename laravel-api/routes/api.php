<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Laravel Task API is running',
    ]);
});

Route::apiResource('tasks', TaskController::class);
