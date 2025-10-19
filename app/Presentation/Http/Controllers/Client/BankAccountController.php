<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Domain\Models\BankAccount;
use App\Presentation\Http\Controllers\Controller;
use App\Domain\Models\User;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{


    public function __construct()
    {
        parent::__construct();
    }


    public function index()
    {

        /** @var User $user */
        $user = Auth::user();
        $accounts = $user->getBankAccounts();

        return view('client.bank_accounts.index', compact('accounts'));
    }



    public function show(BankAccount $account)
    {
        return view('client.bank_accounts.show', compact('account'));
    }



}
