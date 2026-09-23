<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('attendance'));
    }

    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(['hadir', 'terlambat', 'izin', 'sakit', 'alpha'])],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Pilih status kehadiran.',
            'status.in' => 'Status kehadiran tidak valid.',
            'check_in_time.date_format' => 'Format jam masuk tidak valid.',
            'check_out_time.date_format' => 'Format jam pulang tidak valid.',
        ];
    }
}
