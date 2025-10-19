<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Application\Services\UserService;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\ProfileRequest;
use App\Domain\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    public function __construct(private UserService $userService)
    {
        parent::__construct();
    }


    public function show()
    {
        $user = Auth::user();
        return view('client.profile.show', compact('user'));
    }


    public function update(ProfileRequest $request)
    {

        /** @var User $user */
        $user = Auth::user();
        $this->userService->updateUser($user, $request);
        return redirect()->route('profile')->with('success', 'Profil byl úspěšně aktualizován.');
    }



}
