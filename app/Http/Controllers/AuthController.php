<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function showLoginForm()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $result = $this->authService->login($credentials, $request);

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


}
