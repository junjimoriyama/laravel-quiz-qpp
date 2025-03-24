
<x-admin-layout>
    <h1>クイズ</h1>
    @foreach ($quizzes as $quiz)
        <p>{{$quiz['question']}}</p>
    @endforeach
</x-admin-layout>

