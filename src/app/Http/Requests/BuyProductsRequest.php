<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BuyProductsRequest extends FormRequest
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
            'provider_id' => 'required|uuid|exists:providers,id',
            'storage_id' => 'required|uuid|exists:storages,id',
            'total_cost' => 'required|numeric|min:0',
            'products' => 'required|array',
            'products.*.product_id' => 'required|uuid|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ];
    }
}
