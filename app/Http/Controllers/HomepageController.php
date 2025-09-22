<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\UserRepository;

class HomepageController extends Controller
{


    protected $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }


    public function homepage()
    {

        foreach ($this->userRepo->getAll() as $user) {
            dump($user->full_name);
        }

        return view('homepage', [
            'promenna' => 'hello world'
        ]);
    }



}
