<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Presentation\Http\Controllers\Controller;

class StandingOrderController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {
        return view('client.standing_orders.index');
    }



}
