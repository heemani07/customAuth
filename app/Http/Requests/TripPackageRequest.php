<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TripPackageRequest extends FormRequest
{
    public function authorize()
    {
        return true; // or add authorization logic if needed
    }

    public function rules()
    {
        return [
            'destination_id' => 'required|exists:destinations,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'overview' => 'nullable|string',
            'terms_and_conditions' => 'nullable|string',
            'itinerary' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
            'inclusions' => 'nullable|array',
            'inclusions.*' => 'nullable|string|max:255',
            'uploaded_images' => 'nullable|array',
            'uploaded_images.*' => 'nullable|string',
        ];
    }
}
