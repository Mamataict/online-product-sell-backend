<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBranchStoreRequest extends FormRequest
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
            'branch_info_id' => 'required|exists:branch_infos,id',
            'name' => 'required|string|max:255',
            'store_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('stores', 'store_code')->where(function ($query) {
                    return $query->where('branch_info_id', $this->branch_info_id);
                }),
            ],
            'is_active' => 'required|boolean',
        ];
    }
}
