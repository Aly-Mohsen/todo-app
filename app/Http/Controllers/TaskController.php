<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class TaskController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
{
    $query = Auth::user()->tasks()->orderBy('due_date');

    // Filter by completion
    if ($request->has('status') && in_array($request->status, ['complete', 'incomplete'])) {
        $query->where('is_complete', $request->status === 'complete');
    }

    // Search by title or description
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
        });
    }

    $tasks = $query->paginate(10)->withQueryString();

    return view('tasks.index', compact('tasks'));
}

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',

        ]);

        Auth::user()->tasks()->create($request->only('title', 'description', 'due_date', 'priority'));

        return redirect()->route('tasks.index')->with('success', 'Task added!');
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task); // only the owner can edit
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',

        ]);

        $task->update($request->only('title', 'description', 'due_date', 'priority'));

        return redirect()->route('tasks.index')->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }
    public function toggle(Task $task)
    {
        $this->authorize('update', $task); // ensure only the owner can toggle

        $task->is_complete = !$task->is_complete;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task status updated!');
    }
}
