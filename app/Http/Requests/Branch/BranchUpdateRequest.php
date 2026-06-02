<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'branch_code' =>
            [
                'nullable',
                'string',
                'max:50',
                Rule::unique('branch_infos', 'branch_code')->ignore($this->route('branch')),
            ],
            'address' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ];
    }
}
