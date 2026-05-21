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
        $status = $request->input('status');
        $search = $request->input('search');

        $query = Task::query()->orderBy('id', 'desc');

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $tasks = $query->get();

        return response()->json([
            'data' => $tasks,
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

    public function show($id): JsonResponse
    {
        $task = Task::findOrFail($id);

        return response()->json([
            'data' => $task,
            'message' => 'Task loaded successfully',
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $task = Task::findOrFail($id);

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

    public function destroy($id): JsonResponse
    {
        $task = Task::findOrFail($id);

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
