<x-admin-layout>
    <h1 class="mb-5">各レベル</h1>
    <div class="flex gap-5">
        <button onclick="location.href='{{ route('admin.levels.form', 'basic') }}'"
            class="px-2 py-1 rounded-md bg-white text-blue-900">初級
        </button>
        <button
        onclick="location.href='{{ route('admin.levels.form', 'mid') }}'"
        class="px-2 py-1 rounded-md bg-white text-blue-900">中級</button>
        <button
        onclick="location.href='{{ route('admin.levels.form', 'pro') }}'"
        class="px-2 py-1 rounded-md bg-white text-blue-900">上級</button>
    </div>
</x-admin-layout>
