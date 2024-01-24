<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusinessRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'required|string',
            'history'       => 'required|string',
            'email'         => 'required|email',
            'address'       => 'required|string|max:255',
            'zip_code'      => 'required|string|max:5',
            'city'          => 'required|string|max:255',
            'speciality'    => 'array',
            'layer'         => 'image',
            'color_hex_1'   => 'hex_color',
            'color_hex_2'   => 'hex_color',
        ];
    }
}
