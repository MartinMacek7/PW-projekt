<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Enums\AccountType;
use App\Domain\Enums\Currency;
use App\Domain\Models\BankAccount;
use App\Domain\Models\User;
use App\Presentation\Http\Requests\AdminBankAccountRequest;
use Illuminate\Http\Request;

class AdminBankAccountController extends AdminController
{
    public function index(Request $request)
    {
        $query = BankAccount::with('user');

        if ($request->filled('account_number')) {
            $query->where('account_number', 'like', '%' . $request->account_number . '%');
        }

        if ($request->filled('user_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%')
                  ->orWhere('surname', 'like', '%' . $request->user_name . '%');
            });
        }

        $accounts = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.bank_accounts.index', compact('accounts'));
    }


    public function show(BankAccount $bankAccount)
    {
        $transactions = $bankAccount->transactions()->orderBy('created_at','desc')->get();
        return view('admin.bank_accounts.show', compact('bankAccount', 'transactions'));
    }


    public function destroy(BankAccount $bankAccount)
    {

        if ($bankAccount->balance > 0) {
            return redirect()->back()->with('error', 'Účet nelze zrušit, protože má zůstatek.');
        }

        $bankAccount->delete();

        return redirect()->route('admin.bank_accounts.index')->with('success', 'Účet byl zrušen.');
    }


    public function create()
    {
        $users = User::all();
        $currencies = Currency::cases();
        $accountTypes = AccountType::cases();

        return view('admin.bank_accounts.create', compact('users', 'currencies', 'accountTypes'));
    }

   public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'currency' => 'required|in:USD,EUR,CZK',
            'account_type' => 'required|in:1,2',
        ]);

        $maxAccountNumber = \App\Domain\Models\BankAccount::max('account_number');
        $newAccountNumber = $maxAccountNumber ? $maxAccountNumber + 1 : 1000000000;

        $bankAccount = BankAccount::create([
            'user_id' => $request->user_id,
            'account_number' => $newAccountNumber,
            'currency' => $request->currency,
            'account_type' => $request->account_type,
            'balance' => 0,
        ]);

        if ($request->account_type == AccountType::CHECKING->value){
            $this->createCardForAccount($bankAccount);
        }



        return redirect()->route('admin.bank_accounts.index')->with('success', 'Účet byl vytvořen.');
    }


    private function createCardForAccount($bankAccount): void
    {
        $cardNumber = $this->generateCardNumber();
        $cvv = rand(100, 999);
        $expireMonth = rand(1, 12);
        $expireYear = now()->addYears(3)->year;

        \App\Domain\Models\Card::create([
            'bank_account_id' => $bankAccount->id,
            'card_number' => $cardNumber,
            'cvv' => $cvv,
            'expire_month' => $expireMonth,
            'expire_year' => $expireYear,
            'is_active' => true,
        ]);
    }

    private function generateCardNumber(): string
    {
        do {
            $number = '5100' . str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
        } while (\App\Domain\Models\Card::where('card_number', $number)->exists());

        return $number;
    }


}
