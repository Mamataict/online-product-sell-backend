<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignDetailsRequest extends FormRequest
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
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|string|max:30',
            'effect_date' => 'required|date',
            'campaign_info_id' => 'required|exists:campaign_infos,id',
            'is_active' => 'required|boolean',
        ];
    }
}
