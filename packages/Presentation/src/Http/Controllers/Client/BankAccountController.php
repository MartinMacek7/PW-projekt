<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\Interface\IBankAccountService;
use Domain\Models\BankAccount;
use Presentation\Http\Controllers\Controller;
use Domain\Models\User;
use Illuminate\Support\Facades\Auth;


class BankAccountController extends Controller
{


    public function __construct(private IBankAccountService $bankAccountService)
    {
        parent::__construct();
    }


    public function index()
    {

        /** @var User $user */
        $user = Auth::user();
        $accounts = $user->getBankAccounts();

        return view('presentation::client.bank_accounts.index', compact('accounts'));
    }



    public function show(BankAccount $account)
    {
        return view('presentation::client.bank_accounts.show', compact('account'));
    }


    public function exportPdf(BankAccount $account)
    {
        return $this->bankAccountService->generatePdf($account);
    }



}
