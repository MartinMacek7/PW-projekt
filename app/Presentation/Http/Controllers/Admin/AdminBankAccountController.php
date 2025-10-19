<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\BankAccount;
use App\Domain\Models\User;
use App\Domain\Enums\Currency;
use App\Domain\Enums\AccountType;
use App\Presentation\Http\Requests\AdminBankAccountRequest;
use App\Application\Services\BankAccountService;
use Illuminate\Http\Request;

class AdminBankAccountController extends AdminController
{

    public function __construct(private BankAccountService $bankAccountService) {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $accounts = $this->bankAccountService->filterAccounts($request->all());
        return view('admin.bank_accounts.index', compact('accounts'));
    }


    public function show(BankAccount $bankAccount)
    {
        $transactions = $this->bankAccountService->getTransactions($bankAccount);
        return view('admin.bank_accounts.show', compact('bankAccount', 'transactions'));
    }


    public function create()
    {
        $users = User::all();
        $currencies = Currency::cases();
        $accountTypes = AccountType::cases();

        return view('admin.bank_accounts.create', compact('users', 'currencies', 'accountTypes'));
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
