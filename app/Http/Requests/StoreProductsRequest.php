<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductsRequest extends FormRequest
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
            'description' => 'required|string',
            'price' => 'required|decimal:2',
            'height' => 'decimal:2',
            'width' => 'decimal:2',
            'depth' => 'decimal:2',
            'capacity' => 'decimal:2',
            'category' => 'string|max:255',
            'material' => 'string|max:255',
            'style' => 'string|max:255',
            'color' => 'string|max:255',
            'stock' => 'required|integer',
            'image' => 'image',
        ];
    }
}
