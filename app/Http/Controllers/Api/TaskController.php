<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller; 
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // GET /api/tasks
    public function index()
    {
    $tasks = Task::orderBy('is_done')->orderBy('due_date')->get();
    return response()->json($tasks, 200);
    }


    // POST /api/tasks
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'is_done' => 'required|boolean',
            'description' => 'nullable|string',


        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    // GET /api/tasks/{id}
    public function show($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json($task, 200);
    }

    // PUT /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string',
            'priority' => 'sometimes|required|in:low,medium,high',
            'due_date' => 'sometimes|required|date',
            'is_done' => 'required|boolean',
            'description' => 'nullable|string',
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
    }

    // DELETE /api/tasks/{id}
    public function destroy($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted'], 200);
    }
}
