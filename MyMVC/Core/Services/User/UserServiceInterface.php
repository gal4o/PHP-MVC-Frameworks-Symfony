<?php

namespace Core\Services\User;


interface UserServiceInterface
{
    public function register($username, $password): bool;
}