<?php

namespace App\Http\Requests\TenantRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTenantFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fullname' => ['required', 'string'],
            'contact_number' => ['required', 'max:11'],
            'email' => ['nullable', 'email'],
            'has_downpayment' => ['sometimes', 'required', 'boolean:strict'],
            'payment_amount' => ['sometimes', 'required', 'numeric', 'decimal:0,2'],
            'date_paid' => ['sometimes', 'required', 'date']
        ];
    }
}
