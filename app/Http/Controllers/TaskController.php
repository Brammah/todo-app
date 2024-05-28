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
        $tasks = Task::with('user')->get()->groupBy('status');

        return Inertia::render('ToDo/ViewTodo', [
            'tasks' => $tasks,
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
        //
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
        $validatedData = $request->validate([
            'name' => ['required', 'string'],
            'status' => ['required', 'string'],
            'priority' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

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

}
