<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Domain\Models\Loan;
use App\Application\Services\LoanService;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{

    public function __construct(private LoanService $loanService)
    {
        parent::__construct();
    }


    public function index()
    {
        $loans = $this->loanService->getUserLoans(Auth::id());
        return view('client.loans.index', compact('loans'));
    }


    public function create()
    {
        return view('client.loans.create');
    }


    public function store(LoanRequest $request)
    {
        $loan = $this->loanService->createLoan($request->validated());

        return redirect()
            ->route('loans.show', $loan)
            ->with('success', 'Žádost o úvěr byla odeslána.');
    }


    public function show(Loan $loan)
    {
        return view('client.loans.show', compact('loan'));
    }


    public function destroy(Loan $loan)
    {
        if (!$this->loanService->deleteLoan($loan)) {
            return redirect()
                ->route('loans')
                ->with('error', 'Tento úvěr již byl schválen a nelze jej zrušit.');
        }

        return redirect()
            ->route('loans')
            ->with('success', 'Žádost o úvěr byla zrušena.');
    }
}
