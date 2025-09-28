<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
{


    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {

        $userId = Auth::user()?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'birth_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'birth_number')->ignore($userId),
            ],
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone_number')->ignore($userId),
            ],
            'gender' => ['required', 'in:M,F'],
            'password' => $this->isMethod('post')
                ? ['required', 'confirmed', Password::min(8)] // registrace
                : ['nullable', 'confirmed', Password::min(8)], // update
            'address_street' => ['required', 'string', 'max:255'],
            'address_number' => ['required', 'string', 'max:20'],
            'address_city' => ['required', 'string', 'max:255'],
            'address_zip_code' => ['required', 'string', 'max:10'],
        ];
    }


}
