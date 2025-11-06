<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
public function authorize(): bool
{
    return true;
}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
       // dd(request()->all());
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'status' => 'required|in:active,inactive',
        ];
    }

      public function messages(): array
    {
        return [
            'name.required' => 'Please enter destination name.',
            'categories.required' => 'Please select at least one category.',
            'status.required' => 'Please choose a status.',
        ];
    }
}
