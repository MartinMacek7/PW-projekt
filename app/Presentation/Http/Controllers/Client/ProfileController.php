<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\ProfileRequest;
use App\Domain\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }


    public function show()
    {
        $user = Auth::user();
        return view('client.profile.show', compact('user'));
    }

    // todo zkontrolovat profile

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $values = $request->validated();

        /** @var User $user */
        $user->fill(Arr::except($values, ['password']));

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profil byl úspěšně aktualizován.');
    }



}
