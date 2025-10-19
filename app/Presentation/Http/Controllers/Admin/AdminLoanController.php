<?php

namespace App\Presentation\Http\Controllers\Admin;

use App\Domain\Models\Loan;
use App\Application\Services\LoanService;
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
        return view('admin.loans.index', compact('loans'));
    }


    public function show(Loan $loan)
    {
        $loan->load('user');
        return view('admin.loans.show', compact('loan'));
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
