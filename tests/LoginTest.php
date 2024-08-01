<?php
use PHPUnit\Framework\TestCase;
use Pamudu\LowaStateLibrary\Login;

class LoginTest extends TestCase
{
    private $pdo;
    private $login;

    protected function setUp(): void
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=lowastatelibrary', 'root', '');
        $this->login = new Login($this->pdo);
    }

    public function testAuthenticateWithValidCredentials()
    {
        $email = 'hi@gmail.com';
        $password = '1234'; // Assuming the password is hashed in the database

        $user = $this->login->authenticate($email, $password);

        $this->assertNotFalse($user);
        $this->assertEquals($email, $user['email']);
    }

    public function testAuthenticateWithInvalidCredentials()
    {
        $email = 'hi@gmail.com';
        $password = 'wrongpassword';

        $user = $this->login->authenticate($email, $password);

        $this->assertFalse($user);
    }
}
