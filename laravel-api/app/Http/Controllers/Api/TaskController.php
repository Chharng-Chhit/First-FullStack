<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Task::query()->latest();

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return response()->json([
            'data' => $query->get(),
            'message' => 'Tasks loaded successfully',
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'status' => ['nullable', 'in:pending,completed'],
                'due_date' => ['nullable', 'date'],
                'priority' => ['nullable', 'in:low,medium,high'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $task = Task::create($data);

        return response()->json([
            'data' => $task,
            'message' => 'Task created successfully',
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        return response()->json([
            'data' => $task,
            'message' => 'Task loaded successfully',
        ]);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        try {
            $data = $request->validate([
                'title' => ['sometimes', 'required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'status' => ['sometimes', 'required', 'in:pending,completed'],
                'due_date' => ['nullable', 'date'],
                'priority' => ['nullable', 'in:low,medium,high'],
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        }

        $task->update($data);

        return response()->json([
            'data' => $task,
            'message' => 'Task updated successfully',
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
