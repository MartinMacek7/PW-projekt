<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository
{

    public function filter(array $filters): LengthAwarePaginator
    {
        $query = User::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%')
                  ->orWhere('surname', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['phone_number'])) {
            $query->where('phone_number', 'like', '%' . $filters['phone_number'] . '%');
        }

        if (!empty($filters['birth_number'])) {
            $query->where('birth_number', 'like', '%' . $filters['birth_number'] . '%');
        }

        return $query->orderBy('surname')->paginate(15);
    }


    public function updateRole(User $user, int $role): bool
    {
        $user->permission_level = $role;
        return $user->save();
    }


    public function delete(User $user): bool
    {
        return $user->delete();
    }


    public function findById(int $id): ?User
    {
        return User::find($id);
    }

}
