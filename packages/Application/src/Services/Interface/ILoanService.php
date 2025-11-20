<?php

namespace Application\Services\Interface;

use Domain\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ILoanService
{
    public function getUserLoans(int $userId): Collection;

    public function filterLoans(array $filters): LengthAwarePaginator;

    public function createLoan(array $data): Loan;

    public function approveLoan(Loan $loan): void;

    public function deleteLoan(Loan $loan): bool;
}
