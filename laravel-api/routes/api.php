<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'Laravel Task API is running',
    ]);
});


Route::get('tasks', [TaskController::class, 'index']); // /api/tasks
Route::post('tasks', [TaskController::class, 'store']);
Route::get('tasks/{id}', [TaskController::class, 'show']);
Route::put('tasks/{id}', [TaskController::class, 'update']);
Route::delete('tasks/{id}', [TaskController::class, 'destroy']);


// Route::middleware(function ($request, $next) {
//     if ($request->bearerToken() !== 'secret123') {
//         return response()->json(['message' => 'Unauthorized'], 401);
//     }
//     return $next($request);
// })->group(function () {
//     Route::get('tasks', [TaskController::class, 'index']);
//     Route::post('tasks', [TaskController::class, 'store']);
//     Route::get('tasks/{id}', [TaskController::class, 'show']);
//     Route::put('tasks/{id}', [TaskController::class, 'update']);
//     Route::delete('tasks/{id}', [TaskController::class, 'destroy']);
// });


// Route::get('tasks', [TaskController::class, 'index'])->middleware(CheckApiKey::class);
// Route::post('tasks', [TaskController::class, 'store'])->middleware(CheckApiKey::class);
// Route::get('tasks/{id}', [TaskController::class, 'show'])->middleware(CheckApiKey::class);
// Route::put('tasks/{id}', [TaskController::class, 'update'])->middleware(CheckApiKey::class);
// Route::delete('tasks/{id}', [TaskController::class, 'destroy'])->middleware(CheckApiKey::class);