<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignMentorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'mentor_id' => ['required', Rule::exists('users', 'id')->where('role', 'mentor')],
        ];
    }

    public function messages(): array
    {
        return [
            'mentor_id.required' => 'Pilih mentor pembimbing terlebih dahulu.',
            'mentor_id.exists' => 'Mentor yang dipilih tidak valid.',
        ];
    }
}
