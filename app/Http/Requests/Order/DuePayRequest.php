<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class DuePayRequest extends FormRequest
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
            'due_paid_amount' => 'required|numeric|min:0',
            'due_paid_date' => 'required|date',
            'remark' => 'nullable|string|max:255',
            'due_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
        ];
    }
}
