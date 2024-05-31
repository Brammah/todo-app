<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->latest()->get()->groupBy('status');

        $counts = [
            'complete' => 0,
            'pending' => 0,
            'backlog' => 0,
            'highest_priority' => 0,
            'medium_priority' => 0,
            'lowest_priority' => 0,
        ];

        foreach ($tasks as $status => $tasksByStatus) {
            $counts[$status] = $tasksByStatus->count();
        }

        if (isset($tasks['pending'])) {
            foreach ($tasks['pending'] as $task) {
                if (isset($task->priority) && in_array($task->priority, ['highest', 'medium', 'lowest'])) {
                    $counts[$task->priority . '_priority']++;
                }
            }
        }

        $user = auth()->user();

        return Inertia::render('ToDo/ViewTodo', [
            'user' => $user,
            'tasks' => $tasks,
            'counts' => $counts,
            'successMessage' => session('success'),
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $this->validatedRequest($request);

        DB::transaction(function () use ($validatedData) {
            Task::create($validatedData + ['user_id' => auth()->id()]);
            return response()->json(['success' => 'Task Created'], 200);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validatedData = $this->validatedRequest($request);

        DB::transaction(function () use ($validatedData, $task) {
            $task->update($validatedData);
            return response()->json(['success' => 'Task Updated'], 200);
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json(['success' => 'Task Deleted'], 200);
    }

    private function validatedRequest(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
    }
}