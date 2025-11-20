<?php

namespace Presentation\Http\Controllers\Admin;

use Domain\Models\Loan;
use Application\Services\LoanService;
use Illuminate\Http\Request;

class AdminLoanController extends AdminController
{

    public function __construct(private LoanService $loanService)
    {
        parent::__construct();
    }


    public function index(Request $request)
    {
        $loans = $this->loanService->filterLoans($request->all());
        return view('presentation::admin.loans.index', compact('loans'));
    }


    public function show(Loan $loan)
    {
        $loan->load('user');
        return view('presentation::admin.loans.show', compact('loan'));
    }


    public function approve(Loan $loan)
    {
        $this->loanService->approveLoan($loan);
        return redirect()->route('admin.loans.index')->with('success', 'Úvěr byl schválen.');
    }


    public function destroy(Loan $loan)
    {
        $this->loanService->deleteLoan($loan);
        return redirect()->route('admin.loans.index')->with('success', 'Úvěr byl odstraněn.');
    }

}
