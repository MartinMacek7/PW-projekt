<?php

namespace App\Presentation\Http\Controllers\Client;

use App\Domain\Models\Loan;
use App\Presentation\Http\Controllers\Controller;
use App\Presentation\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{


    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())->get();
        return view('client.loans.index', compact('loans'));
    }


    public function create()
    {
        return view('client.loans.create');
    }


    public function store(LoanRequest $request)
    {
        $data = $request->validated();

        $requestedAmount = $data['requested_amount'];
        $months = $data['months'];

        // Fixní roční úrok 5%
        $annualInterestRate = 5;
        $monthlyInterestRate = $annualInterestRate / 12 / 100;

        // Celková částka s úroky: jednoduchý vzorec pro složený úrok
        $totalBalance = $requestedAmount * pow(1 + $monthlyInterestRate, $months);

        // Měsíční splátka
        $monthlyPayment = $totalBalance / $months;

        // Úrok v procentech (celkem přeplaceno)
        $interestRate = (($totalBalance - $requestedAmount) / $requestedAmount) * 100;

        $loan = Loan::create([
            'user_id' => auth()->id(),
            'interest_rate' => round($interestRate, 2),
            'monthly_payment' => round($monthlyPayment, 2),
            'total_balance' => round($totalBalance, 2),
            'remaining_balance' => round($totalBalance, 2),
            'approved' => false,
        ]);

        return redirect()->route('loans.show', $loan)
                        ->with('success', 'Žádost o úvěr byla odeslána.');
    }



    public function show(Loan $loan)
    {
        return view('client.loans.show', compact('loan'));
    }

    public function destroy(Loan $loan)
    {

        if ($loan->approved) {
            return redirect()->route('loans')
                            ->with('error', 'Tento úvěr již byl schválen a nelze jej zrušit.');
        }

        $loan->delete();

        return redirect()->route('loans')
                        ->with('success', 'Žádost o úvěr byla zrušena.');
    }


}
