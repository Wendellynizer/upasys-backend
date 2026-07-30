<?php

namespace App\Http\RentalUnit\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRentalUnitRequest extends FormRequest
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
            'unit_name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'base_rent_amount' => ['required', 'decimal:2'],
            'payment_frequency_id' => ['required', 'integer'],
        ];
    }
}
