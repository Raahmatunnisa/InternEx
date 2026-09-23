<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMahasiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:8'],
            'is_active' => ['nullable', 'boolean'],

            // Data penempatan magang (opsional saat pembuatan akun, bisa
            // dilengkapi kemudian lewat halaman Relasi Mahasiswa-Mentor).
            'mentor_id' => ['nullable', Rule::exists('users', 'id')->where('role', 'mentor')],
            'internship_period_id' => ['nullable', 'exists:internship_periods,id'],
            'division_id' => ['nullable', 'exists:divisions,id'],
            'institution' => ['nullable', 'string', 'max:255'],
            'program' => ['nullable', 'string', 'max:255'],
            'start_date' => ['nullable', 'date', 'required_with:mentor_id,internship_period_id'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'mentor_id.exists' => 'Mentor yang dipilih tidak valid.',
            'start_date.required_with' => 'Tanggal mulai wajib diisi jika mentor/periode ditentukan.',
        ];
    }
}
