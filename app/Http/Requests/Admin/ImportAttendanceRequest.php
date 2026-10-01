<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'internship_period_id' => ['required', 'exists:internship_periods,id'],
            'file' => ['required', 'file', 'mimes:xlsx', 'max:10240'],
        ];
    }

    public function messages(): array
    {
        return [
            'internship_period_id.required' => 'Pilih periode magang untuk mencocokkan data mahasiswa.',
            'file.required' => 'Silakan pilih file Excel (.xlsx) yang akan diimpor.',
            'file.mimes' => 'File harus berformat .xlsx.',
            'file.max' => 'Ukuran file maksimal 10MB.',
        ];
    }
}
