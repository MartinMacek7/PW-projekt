<?php

namespace Presentation\Http\Requests;

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


    public function messages(): array
    {
        return [
            'name.required' => 'Jméno je povinné.',

            'surname.required' => 'Příjmení je povinné.',

            'email.required' => 'E-mail je povinný.',
            'email.email' => 'Zadejte platnou e-mailovou adresu.',
            'email.unique' => 'Tento e-mail je již používán.',

            'birth_number.required' => 'Rodné číslo je povinné.',
            'birth_number.max' => 'Rodné číslo nesmí být delší než 20 znaků.',
            'birth_number.unique' => 'Toto rodné číslo je již používáno.',

            'phone_number.required' => 'Telefonní číslo je povinné.',
            'phone_number.max' => 'Telefonní číslo nesmí být delší než 20 znaků.',
            'phone_number.unique' => 'Toto telefonní číslo je již používáno.',

            'gender.required' => 'Pohlaví je povinné.',
            'gender.in' => 'Vyberte platné pohlaví.',

            'password.required' => 'Heslo je povinné.',
            'password.confirmed' => 'Hesla se neshodují.',
            'password.min' => 'Heslo musí mít alespoň 8 znaků.',

            'address_street.required' => 'Ulice je povinná.',

            'address_number.required' => 'Číslo popisné je povinné.',

            'address_city.required' => 'Město je povinné.',

            'address_zip_code.required' => 'PSČ je povinné.',
            'address_zip_code.max' => 'PSČ nesmí být delší než 10 znaků.',
        ];
    }


}
