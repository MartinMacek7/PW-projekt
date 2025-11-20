<?php

namespace Presentation\Http\Controllers\Client;

use Application\Services\Interface\ILoanService;
use Domain\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Presentation\Http\Controllers\Controller;
use Presentation\Http\Requests\LoanRequest;

class LoanController extends Controller
{

    public function __construct(private ILoanService $loanService)
    {
        parent::__construct();
    }


    public function index()
    {
        $loans = $this->loanService->getUserLoans(Auth::id());
        return view('presentation::client.loans.index', compact('loans'));
    }


    public function create()
    {
        return view('presentation::client.loans.create');
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
        return view('presentation::client.loans.show', compact('loan'));
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
