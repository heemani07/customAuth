<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        // allow all authorized users
        return true;
    }

    public function rules(): array
    {
        return [
            'question' => 'required|string|min:5|max:255',
            'answer' => 'required|string|min:5',
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Please enter a question.',
            'question.min' => 'Question must be at least 5 characters.',
            'answer.required' => 'Please enter an answer.',
            'answer.min' => 'Answer must be at least 5 characters.',
        ];
    }
}
