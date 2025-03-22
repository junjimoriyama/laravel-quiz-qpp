<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // バリデーション
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:1000'],
            'solution' => ['required', 'string', 'max:1000'],
            'correct_answer' => ['required', 'string', 'between:1,4'],
            'content' => ['required', 'array', 'size:4'],
            'content.*' => ['required', 'string', 'max:1000'],
        ];
    }
}
