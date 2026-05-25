<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegistrationRequest extends FormRequest
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
           'name'          => 'required|min:3',
            'position'      => 'required',
            'company_name'  => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:8|confirmed',
            'terms'         => 'accepted',

        ];
    }
    public function massages():array
    {
        return[
              'name.required'         => 'Full name is required.',
            'name.min'              => 'Name must be at least 3 characters.',
            'position.required'     => 'Position / Title is required.',
            'company_name.required' => 'Company name is required.',
            'email.required'        => 'Email address is required.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'This email is already registered.',
            'password.required'     => 'Password is required.',
            'password.min'          => 'Password must be at least 8 characters.',
            'password.confirmed'    => 'Passwords do not match.',
            'terms.accepted'        => 'You must agree to the Terms of Service.',
        ];
    }
}
