<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    private TaskRepositoryInterface $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function index()
    {
        $tasks = $this->taskRepository->all();
        return response()->json($tasks, 200);
    }

    public function show(int $id)
    {
        if (!($task = $this->taskRepository->find($id))) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);

        if (!($task = $this->taskRepository->create($data))) {
            return response()->json(['message' => 'Task not created'], 422);
        }
        return response()->json($task, 201);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);

        if (!($task = $this->taskRepository->update($id, $data))) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task, 200);
    }

    public function destroy(int $id)
    {
        if (!($deleted = $this->taskRepository->delete($id))) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(null, 204);
    }
}
