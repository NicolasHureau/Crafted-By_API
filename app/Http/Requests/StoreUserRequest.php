<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'lastname'  => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|confirmed',
//            'address'   => 'required|string|max:255',
//            'zip_code'  => 'required|string|max:5',
//            'city'      => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'lastname.required'     => 'The lastname field is required.',
            'lastname.string'       => 'The lastname field must be a string.',
            'lastname.max'          => 'The lastname field must not exceed 255 characters.',
            'firstname.required'    => 'The firstname field is required.',
            'firstname.string'      => 'The firstname field must be a string.',
            'firstname.max'         => 'The firstname field must not exceed 255 characters.',
            'email.required'        => 'The email field is required.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'The email address is already in use.',
            'password.required'     => 'The password field is required.',
            'password.string'       => 'The password field must be a string.',
            'password.min'          => 'The password must be at least 8 characters long.',
            'password.confirmed'    => 'The password confirmation does not match.',
//            'address.required'      => 'The address field is required.',
//            'address.string'        => 'The address field must be a string.',
//            'address.max'           => 'The address field must not exceed 255 characters.',
//            'zip_code.required'     => 'The zip code field is required.',
//            'zip_code.integer'      => 'The zip code field must be an integer.',
//            'zip_code.max'          => 'The zip code field must not exceed 5 numbers.',
//            'city.required'         => 'The city field is required.',
//            'city.string'           => 'The city field must be a string.',
//            'city.max'              => 'The city field must not exceed 255 characters.',
        ];
    }
}
