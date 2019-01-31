<?php

namespace Core\Services\User;


use Core\Services\Encryption\EncryptionServiceInterface;
use Driver\DatabaseInterface;

class UserService implements UserServiceInterface
{
    private $db;
    private $encryptionService;

    /**
     * UserService constructor.
     * @param $db
     * @param $encryptionService
     */
    public function __construct(DatabaseInterface $db,
                                EncryptionServiceInterface $encryptionService)
    {
        $this->db = $db;
        $this->encryptionService = $encryptionService;
    }

    public function register($username, $password): bool
    {
        echo "hi"; exit();

        $passwordHash = $this->encryptionService->encrypt($password);
        $query = "INSERT INTO users (username, password) VALUES (?, ?)";
        $statement = $this->db->prepare($query);
        return$statement->execute([$username, $passwordHash]);
    }
}