<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewPermitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('review', $this->route('permit'));
    }

    public function rules(): array
    {
        $rules = [
            'review_note' => ['nullable', 'string', 'max:2000'],
        ];

        if ($this->routeIs('*.reject')) {
            $rules['review_note'] = ['required', 'string', 'max:2000'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'review_note.required' => 'Alasan penolakan wajib diisi ketika menolak pengajuan izin.',
        ];
    }
}
