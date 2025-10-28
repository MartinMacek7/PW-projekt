<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Domain\Models\User;

class AdminClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $clientId],
            'birth_number' => ['required', 'string', 'max:20', 'unique:users,birth_number,' . $clientId],
            'phone_number' => ['required', 'string', 'max:20', 'unique:users,phone_number,' . $clientId],
            'gender' => ['required', 'in:M,F'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ];
    }
}
