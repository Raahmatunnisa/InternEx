<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkAssignMentorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'assignments' => ['required', 'array', 'min:1'],
            'assignments.*' => ['required', Rule::exists('users', 'id')->where('role', 'mentor')],
        ];
    }

    public function messages(): array
    {
        return [
            'assignments.required' => 'Tidak ada data mentor untuk disimpan.',
            'assignments.*.required' => 'Pilih mentor pembimbing untuk setiap mahasiswa.',
            'assignments.*.exists' => 'Salah satu mentor yang dipilih tidak valid.',
        ];
    }
}
