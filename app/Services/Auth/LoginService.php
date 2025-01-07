<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\LoginServiceInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginService implements LoginServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(array $credentials): bool
    {
        $user = $this->userRepository->findByEmail($credentials['email']);

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Store user in session or generate token
            auth()->login($user);

            return true;
        }

        return false;
    }
}