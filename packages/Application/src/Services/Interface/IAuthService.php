<?php


namespace Application\Services\Interface;

use Illuminate\Http\Request;

interface IAuthService
{
    public function login(array $credentials, Request $request): array;

    public function logout(Request $request): void;

    public function register(array $values): void;
}
