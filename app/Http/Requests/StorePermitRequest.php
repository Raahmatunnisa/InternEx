<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePermitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Permit::class);
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:sakit,izin'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'reason' => ['required', 'string', 'max:2000'],
            // Dokumen pendukung wajib untuk izin sakit (surat sakit/keterangan dokter),
            // opsional untuk jenis izin lainnya.
            'attachment' => [
                'file', 'mimes:pdf,jpg,jpeg,png,doc,docx', 'max:5120',
                $this->input('type') === 'sakit' ? 'required' : 'nullable',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
            'attachment.required' => 'Dokumen pendukung (surat sakit/keterangan dokter) wajib diunggah untuk pengajuan izin sakit.',
            'attachment.mimes' => 'Dokumen harus berformat PDF, JPG, PNG, DOC, atau DOCX.',
            'attachment.max' => 'Ukuran dokumen maksimal 5MB.',
        ];
    }
}
