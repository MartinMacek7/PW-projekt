<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Application\Services\TransactionService;
use App\Domain\Models\Transaction;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{


    public function __construct(private TransactionService $transactionService)
    {
        parent::__construct();
    }


    public function index()
    {
        $transactions = $this->transactionService->getUserTransactions(Auth::id());
        return view('client.transactions.index', compact('transactions'));
    }


    public function showCreateForm(){
        return view('client.transactions.create');
    }


    public function create(TransactionRequest $request)
    {

        $validated = $request->validated();

        Transaction::create([
            'bank_account_id' => $validated['bank_account_id'],
            'transaction_type' => \App\Domain\Enums\TransactionType::OUTGOING,
            'counterparty_account_number' => $validated['counterparty_account_number'],
            'counterparty_bank_code' => $validated['counterparty_bank_code'] ?? null,
            'vs' => $validated['vs'] ?? null,
            'amount' => $validated['amount'],
            'currency' => $validated['currency'],
            'message' => $validated['message'] ?? null,
            'status' => \App\Domain\Enums\TransactionStatus::PENDING->value,
        ]);

        return redirect()->route('transactions')->with('success', 'Platba byla úspěšně zadána.');
    }





}
