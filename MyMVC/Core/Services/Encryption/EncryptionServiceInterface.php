<?php

namespace Core\Services\Encryption;


interface EncryptionServiceInterface
{
    public function encrypt(string $password): string;
    public function verify(string $password, string $hash): bool;
}