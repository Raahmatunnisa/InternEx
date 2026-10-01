<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLogbookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Logbook::class);
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'before_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'activity' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'output' => ['nullable', 'string', 'max:5000'],
            'obstacle' => ['nullable', 'string', 'max:5000'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_time.after' => 'Jam selesai harus lebih besar dari jam mulai.',
            'date.before_or_equal' => 'Tanggal logbook tidak boleh di masa depan.',
        ];
    }
}
