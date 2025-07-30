<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            My Tasks
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <div x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                x-transition
                class="mb-4 p-4 bg-green-100 text-green-800 rounded relative">
                {{ session('success') }}
                <button @click="show = false" class="absolute top-2 right-2 text-sm text-green-800">×</button>
            </div>
        @endif


        <div class="mb-4 flex justify-between">
            <a href="{{ route('tasks.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Add Task
            </a>
        </div>

        <form method="GET" class="mb-4 flex gap-4 items-end">
            <div>
                <label class="block text-sm text-gray-600">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    class="border border-gray-300 px-3 py-1 rounded w-full"
                    placeholder="Title or Description">
            </div>

            <div>
                <label class="block text-sm text-gray-600">Status</label>
                <select name="status" class="border border-gray-300 px-3 py-1 rounded w-full">
                    <option value="">All</option>
                    <option value="complete" {{ request('status') == 'complete' ? 'selected' : '' }}>Complete</option>
                    <option value="incomplete" {{ request('status') == 'incomplete' ? 'selected' : '' }}>Incomplete</option>
                </select>
            </div>

            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filter
                </button>
            </div>

            <a href="{{ route('tasks.index') }}"
            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                Clear Filters
            </a>
        </form>

        


        @if($tasks->isEmpty())
            <p class="text-gray-600">You have no tasks yet.</p>
        @else
            <div class="overflow-x-auto">
                <p class="mb-2 text-gray-600 text-sm">
                    Showing {{ $tasks->count() }} {{ Str::plural('task', $tasks->count()) }}.
                </p>
                <table class="w-full table-auto bg-white shadow rounded-lg">
                    <thead class="bg-gray-100 text-left text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Completed</th>
                            <th class="px-4 py-2">Priority</th>
                            <th class="px-4 py-2">Due Date</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-800">
                        @foreach ($tasks as $task)
                            <tr class="border-t
                            @if($task->priority === 'High') bg-red-100
                            @elseif($task->priority === 'Medium') bg-yellow-100
                            @elseif($task->priority === 'Low') bg-green-100
                            @endif">
                                <td class="px-4 py-2">{{ $task->title }}</td>
                                <td class="px-4 py-2">{{ $task->description }}</td>
                                <td class="px-4 py-2">
                                    @if($task->is_complete)
                                        <span class="bg-green-100 text-green-700 px-2 py-1 text-xs rounded">Complete</span>
                                    @else
                                        <span class="bg-yellow-200 text-yellow-600 px-2 py-1 text-xs rounded">Incomplete</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2">
                                    @php
                                        $colors = ['High' => 'red', 'Medium' => 'yellow', 'Low' => 'green'];
                                    @endphp
                                    <span class="bg-{{ $colors[$task->priority] }}-100 text-{{ $colors[$task->priority] }}-700 px-2 py-1 rounded text-xs">
                                        {{ $task->priority }}
                                    </span>
                                </td>

                                <td class="px-4 py-2 @if($task->due_date && \Carbon\Carbon::parse($task->due_date)->isPast()) text-red-600 font-bold @endif">
                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-m-Y') : '—' }}
                                </td>
                                <td class="px-4 py-2 flex gap-2">
                                    <a href="{{ route('tasks.edit', $task) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 rounded text-sm">Edit</a>

                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-2 py-1 rounded text-sm">
                                            {{ $task->is_complete ? 'Mark Incomplete' : 'Mark Complete' }}
                                        </button>
                                    </form>

                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4 flex justify-center">
                    {{ $tasks->links() }}
                </div>

            </div>
        @endif
    </div>
</x-app-layout>
