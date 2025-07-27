<?php

namespace App\Services;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService
{
    public function __construct(UserRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    /**
     * @param array $credentials
     * @return bool
     */
    public function authAttempt(array $credentials): bool
    {
        return Auth::attempt($credentials);
    }
}
