<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Presentation\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AdminController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;


    public function __construct()
    {
        $this->middleware('banker');
    }

}
