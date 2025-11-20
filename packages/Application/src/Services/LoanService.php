<?php

namespace Application\Services;

use Domain\Models\Loan;
use Infrastructure\Repositories\LoanRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LoanService
{

    public function __construct(private LoanRepository $loanRepository)
    {}



    public function getUserLoans(int $userId)
    {
        return $this->loanRepository->getLoans($userId);
    }


    public function filterLoans(array $filters): LengthAwarePaginator
    {
        return $this->loanRepository->filter($filters);
    }


    public function createLoan(array $data): Loan
    {
        $requestedAmount = $data['requested_amount'];
        $months = $data['months'];

        // Fixní roční úrok 5 %
        $annualInterestRate = 5;
        $monthlyInterestRate = $annualInterestRate / 12 / 100;

        // Celková částka s úroky
        $totalBalance = $requestedAmount * pow(1 + $monthlyInterestRate, $months);

        // Měsíční splátka
        $monthlyPayment = $totalBalance / $months;

        // Celkový úrok (v %)
        $interestRate = (($totalBalance - $requestedAmount) / $requestedAmount) * 100;

        $data = [
            'user_id' => Auth::id(),
            'interest_rate' => round($interestRate, 2),
            'monthly_payment' => round($monthlyPayment, 2),
            'total_balance' => round($totalBalance, 2),
            'remaining_balance' => round($totalBalance, 2),
            'approved' => false,
        ];

        return $this->loanRepository->create($data);
    }


    public function approveLoan(Loan $loan): void
    {
        $this->loanRepository->update($loan, ['approved' => true]);
    }


    public function deleteLoan(Loan $loan): bool
    {
        if ($loan->approved) {
            return false;
        }

        return $this->loanRepository->delete($loan);
    }
}
