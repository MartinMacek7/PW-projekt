<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\TransactionService;
use Presentation\Http\Controllers\Controller;
use Presentation\Http\Requests\TransactionRequest;
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
        return view('presentation::client.transactions.index', compact('transactions'));
    }


    public function showCreateForm()
    {
        return view('presentation::client.transactions.create');
    }


    public function create(TransactionRequest $request)
    {
        $this->transactionService->createTransaction($request->validated());

        return redirect()
            ->route('transactions')
            ->with('success', 'Platba byla úspěšně zadána.');
    }

}
