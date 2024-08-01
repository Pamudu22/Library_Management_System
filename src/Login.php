<?php
namespace Pamudu\LowaStateLibrary;

class Login
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function authenticate($email, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM logindetails WHERE email = :email');
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }
}
