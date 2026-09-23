<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInternshipPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\InternshipPeriod::class);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status' => ['required', 'in:active,completed'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }
}
