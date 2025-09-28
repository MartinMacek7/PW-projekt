<?php

namespace App\Presentation\Http\Controllers\Client;

use Illuminate\Http\Request;
use App\Application\Services\AuthService;
use App\Presentation\Http\Requests\ProfileRequest;
use App\Presentation\Http\Controllers\Controller;


class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function showLoginForm()
    {
        return view('client.auth.login');
    }


    public function login(Request $request)
    {
        $values = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login($values, $request);

        if ($result['success']) {
            return redirect()->intended(route('homepage'));
        }

        return back()->withErrors([
            $result['field'] => $result['message'],
        ])->withInput();
    }



    public function logout(Request $request)
    {
        $this->authService->logout($request);
        return redirect()->route('login');
    }



    public function showRegisterForm()
    {
        return view('client.auth.register');
    }


    public function register(ProfileRequest $request)
    {
        $values = $request->validated();
        $this->authService->register($values);
        return redirect()->route('homepage')->with('success', 'Registrace proběhla úspěšně.');
    }


}
