<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/dbconnection.inc.php'); // Include the DB connection
require_once(__DIR__ . '/../src/login.php'); // Include the login script

class LoginTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        // Create a new connection directly in the test
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "test_lowastatelibrary"; // Use a test database

        // Create the connection
        $this->conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($this->conn->connect_error) {
            $this->fail("Connection failed: " . $this->conn->connect_error);
        }

        // Clear the tables before each test
        $this->conn->query("DELETE FROM logindetails");
        $this->conn->query("DELETE FROM member");

        // Insert test data
        $this->conn->query("INSERT INTO member (memId, fname, lname, gender, contactno, address) VALUES ('s123', 'John', 'Doe', 'Male', '1234567890', '123 Street, City')");
        $passwordHash = password_hash('password123', PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO logindetails (email, password, authLevel, status, memId) VALUES ('john.doe@example.com', '$passwordHash', 'student', 'active', 's123')");
    }

    public function testLoginWithValidCredentials()
    {
        $_POST['email'] = 'john.doe@example.com';
        $_POST['password'] = 'password123';
        $_POST['submit'] = true;

        ob_start();
        include(__DIR__ . '/../src/login.php');
        $output = ob_get_clean();

        $this->assertTrue(isset($_SESSION['userid']));
        $this->assertEquals('s123', $_SESSION['userid']);
        $this->assertEquals('student', $_SESSION['usertype']);
    }

    public function testLoginWithInvalidCredentials()
    {
        $_POST['email'] = 'john.doe@example.com';
        $_POST['password'] = 'wrongpassword';
        $_POST['submit'] = true;

        ob_start();
        include(__DIR__ . '/../src/login.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Invalid+Username+or+Password', $output);
    }

    public function testLoginWithInactiveAccount()
    {
        $this->conn->query("UPDATE logindetails SET status='inactive' WHERE email='john.doe@example.com'");

        $_POST['email'] = 'john.doe@example.com';
        $_POST['password'] = 'password123';
        $_POST['submit'] = true;

        ob_start();
        include(__DIR__ . '/../src/login.php');
        $output = ob_get_clean();

        $this->assertStringContainsString('Your+account+has+been+temporarily+suspended.', $output);
    }

    protected function tearDown(): void
    {
        // Close the database connection if necessary
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
