<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMentor();
    }

    public function rules(): array
    {
        $mentorId = $this->user()->id;

        return [
            'internship_id' => [
                'required',
                Rule::exists('internships', 'id')->where(fn ($q) => $q->where('mentor_id', $mentorId)),
            ],
            'date' => ['required', 'date', 'before_or_equal:today'],
            'status' => ['required', Rule::in(['hadir', 'terlambat', 'izin', 'sakit', 'alpha'])],
            'check_in_time' => ['nullable', 'date_format:H:i'],
            'check_out_time' => ['nullable', 'date_format:H:i'],
        ];
    }

    public function messages(): array
    {
        return [
            'internship_id.required' => 'Pilih mahasiswa terlebih dahulu.',
            'internship_id.exists' => 'Mahasiswa tidak valid atau bukan bimbingan Anda.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.before_or_equal' => 'Tanggal tidak boleh lebih dari hari ini.',
            'status.required' => 'Pilih status kehadiran.',
            'status.in' => 'Status kehadiran tidak valid.',
            'check_in_time.date_format' => 'Format jam masuk tidak valid.',
            'check_out_time.date_format' => 'Format jam pulang tidak valid.',
        ];
    }
}
