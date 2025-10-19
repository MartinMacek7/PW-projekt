<?php

namespace App\Application\Services;

use App\Domain\Enums\UserRole;
use App\Domain\Models\User;
use App\Infrastructure\Repositories\UserRepository;
use App\Presentation\Http\Requests\AdminClientRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{

    public function __construct(private UserRepository $userRepository)
    {}

    public function updateUser(User $user, AdminClientRequest $request): void
    {
        $data = $request->validated();

        $user->fill(Arr::except($data, ['password']));

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
    }


    public function getFilteredUsers(array $filters): LengthAwarePaginator
    {
        return $this->userRepository->filter($filters);
    }


    public function updateUserRole(User $user, int $newRole): bool
    {
        if (!UserRole::tryFrom($newRole)) {
            return false;
        }

        return $this->userRepository->updateRole($user, $newRole);
    }


    public function deleteUser(User $user): bool
    {
        return $this->userRepository->delete($user);
    }

}
