<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewLogbookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('review', $this->route('logbook'));
    }

    public function rules(): array
    {
        $rules = [
            'feedback' => ['nullable', 'string', 'max:2000'],
        ];

        if ($this->routeIs('*.reject')) {
            $rules['feedback'] = ['required', 'string', 'max:2000'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'feedback.required' => 'Feedback wajib diisi ketika menolak logbook.',
        ];
    }
}
