<?php

namespace Application\Services\Interface;

use Domain\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Presentation\Http\Requests\AdminClientRequest;
use Presentation\Http\Requests\ProfileRequest;

interface IUserService
{
    public function updateUser(User $user, AdminClientRequest|ProfileRequest $request): void;

    public function getFilteredUsers(array $filters): LengthAwarePaginator;

    public function updateUserRole(User $user, int $newRole): bool;

    public function deleteUser(User $user): bool;
}
