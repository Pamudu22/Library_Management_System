<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/dbconnection.inc.php'); // Include the DB connection

class RegisterTest extends TestCase
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
        $this->conn->query("DELETE FROM member");
        $this->conn->query("DELETE FROM logindetails");
    }

    public function testRegisterNewStudent()
    {
        // Simulate form data
        $data = [
            'memid' => 's123',
            'fname' => 'John',
            'lname' => 'Doe',
            'gender' => 'Male',
            'contactno' => '1234567890',
            'address' => '123 Street, City',
            'email' => 'john.doe@example.com',
            'password' => 'password123'
        ];

        // Simulate POST request
        $_POST = array_merge($_POST, $data);

        // Include the registration script
        ob_start();
        include(__DIR__ . '/../src/Register.php');
        ob_end_clean();

        // Check if registration was successful
        $result = $this->conn->query("SELECT * FROM member WHERE memId='s123'");
        $this->assertEquals(1, $result->num_rows);

        $result2 = $this->conn->query("SELECT * FROM logindetails WHERE email='john.doe@example.com'");
        $this->assertEquals(1, $result2->num_rows);
    }

    public function testRegisterWithExistingEmail()
    {
        // Insert a user manually
        $this->conn->query("INSERT INTO member (memId, fname, lname, gender, contactno, address) VALUES ('s999', 'Existing', 'User', 'Male', '1234567890', 'Existing Address')");
        $passwordHash = password_hash('hashedpassword', PASSWORD_DEFAULT);
        $this->conn->query("INSERT INTO logindetails (email, password, authLevel, status, memId) VALUES ('duplicate@example.com', '$passwordHash', 'student', 'pending', 's999')");

        // Simulate form data
        $data = [
            'memid' => 's1000',
            'fname' => 'Jane',
            'lname' => 'Smith',
            'gender' => 'Female',
            'contactno' => '0987654321',
            'address' => '456 Avenue, City',
            'email' => 'duplicate@example.com',
            'password' => 'newpassword123'
        ];

        // Simulate POST request
        $_POST = array_merge($_POST, $data);

        // Include the registration script
        ob_start();
        include(__DIR__ . '/../src/Register.php');
        ob_end_clean();

        // Check if registration failed due to existing email
        $result = $this->conn->query("SELECT * FROM member WHERE memId='s1000'");
        $this->assertEquals(0, $result->num_rows);
    }

    protected function tearDown(): void
    {
        // Close the database connection if necessary
        if ($this->conn) {
            $this->conn->close();
        }
    }
}

?>
