<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\Loan;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class LoanRepository
{

    public function getLoans(int $userId)
    {
        return Loan::where('user_id', $userId)->get();
    }


    public function filter(array $filters): LengthAwarePaginator
    {
        $query = Loan::with('user');

        if (isset($filters['approved'])) {
            $query->where('approved', $filters['approved']);
        }

        if (!empty($filters['user'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['user'] . '%')
                  ->orWhere('surname', 'like', '%' . $filters['user'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['user'] . '%');
            });
        }

        return $query->orderByDesc('created_at')->paginate(15);
    }


    public function create(array $data): Loan
    {
        return Loan::create($data);
    }


    public function update(Loan $loan, array $attributes): void
    {
        $loan->update($attributes);
    }


    public function delete(Loan $loan): bool
    {
        return $loan->delete();
    }

}
