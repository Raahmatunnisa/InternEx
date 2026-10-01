<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssessmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('assess', $this->route('student'));
    }

    /**
     * Mentor hanya menginput 4 komponen nilai (0-100). final_score, grade,
     * dan grade_point dihitung otomatis oleh Assessment model.
     */
    public function rules(): array
    {
        return [
            'attendance_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'logbook_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'final_report_score' => ['required', 'numeric', 'min:0', 'max:100'],
            'presentation_score' => ['required', 'numeric', 'min:0', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'attendance_score.required' => 'Nilai absensi wajib diisi.',
            'logbook_score.required' => 'Nilai logbook wajib diisi.',
            'final_report_score.required' => 'Nilai laporan akhir wajib diisi.',
            'presentation_score.required' => 'Nilai presentasi wajib diisi.',
            '*.numeric' => 'Nilai harus berupa angka.',
            '*.min' => 'Nilai minimal 0.',
            '*.max' => 'Nilai maksimal 100.',
        ];
    }
}
