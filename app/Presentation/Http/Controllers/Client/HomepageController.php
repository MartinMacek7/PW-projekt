<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Infrastructure\Repositories\UserRepository;
use App\Presentation\Http\Controllers\Controller;

class HomepageController extends Controller
{


    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();
    }


    public function homepage()
    {
        return view('client.homepage.homepage');
    }



}
