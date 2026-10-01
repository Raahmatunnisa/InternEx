<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        $division = $this->route('division');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('divisions', 'name')->ignore($division?->id)],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
