<?php

namespace Presentation\Http\Controllers\Client;

use Infrastructure\Repositories\UserRepository;
use Presentation\Http\Controllers\Controller;

class HomepageController extends Controller
{


    public function __construct(UserRepository $userRepo)
    {
        parent::__construct();
    }


    public function homepage()
    {
        return view('presentation::client.homepage.homepage');
    }



}
