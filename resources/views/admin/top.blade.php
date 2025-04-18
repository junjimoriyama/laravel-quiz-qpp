<x-admin-layout>
    <section class="flex flex-col items-center justify-center text-white min-h-[calc(100vh-var(--header-height))]">
        <h1 class="mb-10 text-2xl md:text-4xl">クイズ作成画面</h1>
        <div class="flex gap-5 md:gap-10 text-2xl md:text-4xl">
            <button onclick="location.href='{{ route('admin.quizzes.show', 'basic') }}'"
                class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">初級</button>
            <button onclick="location.href='{{ route('admin.quizzes.show', 'mid') }}'"
                class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">中級</button>
            <button onclick="location.href='{{ route('admin.quizzes.show', 'pro') }}'"
                class="px-4 py-2 rounded-md bg-white text-blue-900 transition duration-300 hover:opacity-50">上級</button>
        </div>
    </section>
</x-admin-layout>
