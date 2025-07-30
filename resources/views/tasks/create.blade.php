<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Create Task</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded mt-6">
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Description</label>
                <textarea name="description"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Priority</label>
                <select name="priority" class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    @foreach (['Low', 'Medium', 'High'] as $level)
                        <option value="{{ $level }}" {{ (old('priority', $task->priority ?? '') == $level) ? 'selected' : '' }}>
                            {{ $level }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">Due Date</label>
                <input type="date" name="due_date"
                    value="{{ old('due_date', isset($task) && $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>



            <div class="flex justify-between">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Create Task
                </button>
                <a href="{{ route('tasks.index') }}" class="text-gray-600 hover:underline">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
