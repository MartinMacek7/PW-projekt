<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\Transaction;
use App\Domain\Enums\TransactionStatus;
use Illuminate\Http\Request;

class AdminTransactionController extends AdminController
{
    public function index(Request $request)
    {
        $query = Transaction::query()
            ->with(['bankAccount.user']);

        // --- Filtrování ---
        if ($request->filled('client')) {
            $query->whereHas('bankAccount.user', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->client}%")
                  ->orWhere('surname', 'like', "%{$request->client}%");
            });
        }

        if ($request->filled('account_number')) {
            $query->whereHas('bankAccount', fn($q) =>
                $q->where('account_number', 'like', "%{$request->account_number}%"));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('transaction_type')) {
            $query->where('transaction_type', $request->transaction_type);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        $transactions = $query->orderBy('created_at', 'desc')->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }


    public function show(Transaction $transaction)
    {
        $transaction->load(['bankAccount.user']);
        return view('admin.transactions.show', compact('transaction'));
    }


    public function block(Transaction $transaction)
    {
        $transaction->update(['status' => TransactionStatus::BLOCKED]);
        return back()->with('success', 'Transakce byla zablokována.');
    }


    public function unblock(Transaction $transaction)
    {
        $transaction->update(['status' => TransactionStatus::PENDING]);
        return back()->with('success', 'Transakce byla odblokována.');
    }


    public function cancel(Transaction $transaction)
    {
        $transaction->update(['status' => TransactionStatus::CANCELLED]);
        return back()->with('success', 'Transakce byla stornována.');
    }
}
