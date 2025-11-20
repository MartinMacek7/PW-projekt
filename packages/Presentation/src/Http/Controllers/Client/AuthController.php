<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\Interface\IAuthService;
use Illuminate\Http\Request;
use Presentation\Http\Controllers\Controller;
use Presentation\Http\Requests\ProfileRequest;


class AuthController extends Controller
{

    protected IAuthService $authService;

    public function __construct(IAuthService $authService)
    {
        $this->authService = $authService;
    }


    public function showLoginForm()
    {
        return view('presentation::client.auth.login');
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
        return view('presentation::client.auth.register');
    }


    public function register(ProfileRequest $request)
    {
        $values = $request->validated();
        $this->authService->register($values);
        return redirect()->route('homepage')->with('success', 'Registrace proběhla úspěšně.');
    }


}
