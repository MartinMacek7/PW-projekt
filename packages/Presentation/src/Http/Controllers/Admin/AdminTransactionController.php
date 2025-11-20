<?php

namespace Presentation\Http\Controllers\Admin;

use Domain\Models\Transaction;
use Domain\Enums\TransactionStatus;
use Application\Services\TransactionService;
use Illuminate\Http\Request;

class AdminTransactionController extends AdminController
{
    public function __construct(private TransactionService $transactionService)
    {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $transactions = $this->transactionService->filterTransactions($request->all());
        return view('presentation::admin.transactions.index', compact('transactions'));
    }


    public function show(Transaction $transaction)
    {
        $transaction->load(['bankAccount.user']);
        return view('presentation::admin.transactions.show', compact('transaction'));
    }


    public function block(Transaction $transaction)
    {
        $this->transactionService->updateStatus($transaction, TransactionStatus::BLOCKED);
        return back()->with('success', 'Transakce byla zablokována.');
    }


    public function unblock(Transaction $transaction)
    {
        $this->transactionService->updateStatus($transaction, TransactionStatus::PENDING);
        return back()->with('success', 'Transakce byla odblokována.');
    }


    public function cancel(Transaction $transaction)
    {
        $this->transactionService->updateStatus($transaction, TransactionStatus::CANCELLED);
        return back()->with('success', 'Transakce byla stornována.');
    }
}
