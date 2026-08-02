<?php

namespace App\Http\Requests\RentalUnitRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalUnitRequest extends FormRequest
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
            'unit_name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'base_rent_amount' => ['nullable', 'numeric', 'decimal:0,2'],
            'payment_frequency_id' => ['nullable', 'integer', 'exists:payment_frequencies,id'],
            'is_available' => ['sometimes', 'boolean'],
        ];
    }
}
