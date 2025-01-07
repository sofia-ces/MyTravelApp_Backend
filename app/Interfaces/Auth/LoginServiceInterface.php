<?php

namespace App\Interfaces\Auth;

interface LoginServiceInterface
{
    public function authenticate(array $credentials): bool;
}