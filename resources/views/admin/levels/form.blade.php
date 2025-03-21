<x-admin-layout>
    <div class="p-5 flex flex-col items-center">
        <h1 class="text-3xl">{{ $level->label }}クイズ登録</h1>
        <form action="">
            <div>1問目</div>
            <label for="">問題</label>
            <input type="text">
            {{-- ここのレベルは{{ $level }} --}}
        </form>
    </div>
</x-admin-layout>
