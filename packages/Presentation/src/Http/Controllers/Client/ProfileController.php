<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\Interface\IUserService;
use Domain\Models\User;
use Illuminate\Support\Facades\Auth;
use Presentation\Http\Controllers\Controller;
use Presentation\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{


    public function __construct(private IUserService $userService)
    {
        parent::__construct();
    }


    public function show()
    {
        $user = Auth::user();
        return view('presentation::client.profile.show', compact('user'));
    }


    public function update(ProfileRequest $request)
    {

        /** @var User $user */
        $user = Auth::user();
        $this->userService->updateUser($user, $request);
        return redirect()->route('profile')->with('success', 'Profil byl úspěšně aktualizován.');
    }



}
