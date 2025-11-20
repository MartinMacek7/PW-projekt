<?php

namespace Presentation\Http\Controllers\Admin;

use Application\Services\Interface\IBankAccountService;
use Domain\Enums\AccountType;
use Domain\Enums\Currency;
use Domain\Models\BankAccount;
use Domain\Models\User;
use Illuminate\Http\Request;
use Presentation\Http\Requests\AdminBankAccountRequest;

class AdminBankAccountController extends AdminController
{

    public function __construct(private IBankAccountService $bankAccountService) {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $accounts = $this->bankAccountService->filterAccounts($request->all());
        return view('presentation::admin.bank_accounts.index', compact('accounts'));
    }


    public function show(BankAccount $bankAccount)
    {
        $transactions = $this->bankAccountService->getTransactions($bankAccount);
        return view('presentation::admin.bank_accounts.show', compact('bankAccount', 'transactions'));
    }


    public function create()
    {
        $users = User::all();
        $currencies = Currency::cases();
        $accountTypes = AccountType::cases();

        return view('presentation::admin.bank_accounts.create', compact('users', 'currencies', 'accountTypes'));
    }


    public function store(AdminBankAccountRequest $request)
    {
        $this->bankAccountService->createAccount($request->validated());

        return redirect()->route('admin.bank_accounts.index')
            ->with('success', 'Účet byl vytvořen.');
    }


    public function destroy(BankAccount $bankAccount)
    {
        $deleted = $this->bankAccountService->deleteAccount($bankAccount);

        if (!$deleted) {
            return redirect()->back()->with('error', 'Účet nelze zrušit, protože má zůstatek.');
        }

        return redirect()->route('admin.bank_accounts.index')
            ->with('success', 'Účet byl zrušen.');
    }
}
