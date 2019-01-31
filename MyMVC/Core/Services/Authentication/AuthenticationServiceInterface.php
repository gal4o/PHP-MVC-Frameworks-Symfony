<?php

namespace Core\Services\Authentication;


interface AuthenticationServiceInterface
{
    public function isLogged(): bool;
    public function login($username, $password): bool;
}