<?php

namespace Application\Services;

use Domain\Enums\UserRole;
use Domain\Models\User;
use Infrastructure\Repositories\UserRepository;
use Presentation\Http\Requests\AdminClientRequest;
use Presentation\Http\Requests\ProfileRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserService
{

    public function __construct(private UserRepository $userRepository)
    {}

    public function updateUser(User $user, AdminClientRequest|ProfileRequest $request): void
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
