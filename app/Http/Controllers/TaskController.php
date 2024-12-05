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
        return response()->json($tasks);
    }

    public function show(int $id)
    {
        $task = $this->taskRepository->find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json($task);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);

        $task = $this->taskRepository->create($data);
        return response()->json($task, 201);
    }

    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'nullable|string',
        ]);

        $updated = $this->taskRepository->update($id, $data);

        if (!$updated) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task updated']);
    }

    public function destroy(int $id)
    {
        $deleted = $this->taskRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['message' => 'Task deleted']);
    }
}
