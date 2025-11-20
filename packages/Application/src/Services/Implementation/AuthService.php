<?php

namespace Application\Services\Implementation;

use Application\Services\Interface\IAuthService;
use Domain\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Infrastructure\Repositories\UserRepository;

class AuthService implements IAuthService
{

    protected UserRepository $userRepo;

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


    public function register(array $values): void
    {

        $user = User::create([
            'name' => $values['name'],
            'surname' => $values['surname'],
            'email' => $values['email'],
            'birth_number' => $values['birth_number'],
            'phone_number' => $values['phone_number'],
            'gender' => $values['gender'],
            'password' => Hash::make($values['password']),
            'address_street' => $values['address_street'],
            'address_number' => $values['address_number'],
            'address_city' => $values['address_city'],
            'address_zip_code' => $values['address_zip_code'],
        ]);

        Auth::login($user);
    }

}
