<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'password' => 'required|string|min:8|confirmed',
            'userName' => 'required|string|unique:users,userName|max:255',
            'phone_number' => 'nullable|string|max:15',
            'email' => 'required|email|unique:users,email|max:255',

            // Address and job
            //'city_id' => 'required|exists:cities,id', // Ensure the city_id exists in the cities table
            'address' => 'nullable|string|max:255',
            'job' => 'required|string|max:255',
        ];
    }
}
