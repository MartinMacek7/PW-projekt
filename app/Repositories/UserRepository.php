<?php

namespace App\Repositories;

use App\Models\User;
use \Illuminate\Database\Eloquent\Collection;

class UserRepository
{

    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }


    public function getAll(): Collection
    {
        return $this->model->all();
    }


    public function getById(int $id): ?User
    {
        return $this->model->find($id);
    }


    public function getByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }


    public function create(array $data): User
    {
        return $this->model->create($data);
    }


}
