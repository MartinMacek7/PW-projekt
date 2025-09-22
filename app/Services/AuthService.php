<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthService
{

    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function login(array $credentials, Request $request): array
    {
        $user = $this->userRepo->getByEmail($credentials['email']);

        if (!$user) {
            return [
                'success' => false,
                'field' => 'email',
                'message' => 'Uživatel s tímto emailem neexistuje.'
            ];
        }

        if (!Auth::attempt($credentials)) {
            return [
                'success' => false,
                'field' => 'password',
                'message' => 'Neplatné heslo.'
            ];
        }

        $request->session()->regenerate();
        return ['success' => true];
    }



    public function logout(Request $request): void
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

}
