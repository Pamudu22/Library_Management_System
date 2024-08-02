<?php
class Login
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function loginUser($email, $password)
    {
        // Check if email is valid
        $sql_email = "SELECT * FROM logindetails WHERE email=?";
        $stmt = $this->conn->prepare($sql_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result_email = $stmt->get_result();

        if ($result_email->num_rows == 1) {
            // User Name Exists in the Database
            $row = $result_email->fetch_assoc();
            $actualPassword = $row['password'];
            $userid = $row['memId'];
            $usertype = $row['authLevel'];
            $accstatus = $row['status'];

            if (password_verify($password, $actualPassword)) {
                if ($accstatus == "active") {
                    // Set session values
                    $_SESSION['userid'] = $userid;
                    $_SESSION['usertype'] = $usertype;

                    // Check reservations
                    include("reservationcheck.inc.php");

                    return [
                        'status' => true,
                        'message' => 'Login successful'
                    ];
                } elseif ($accstatus == "inactive") {
                    return [
                        'status' => false,
                        'message' => 'Your account has been temporarily suspended.'
                    ];
                } elseif ($accstatus == "pending") {
                    return [
                        'status' => false,
                        'message' => 'Your account is not yet verified by the Administrator.'
                    ];
                } else {
                    return [
                        'status' => false,
                        'message' => 'Error signing in, please try again.'
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'message' => 'Invalid Username or Password'
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'Invalid Username or Password'
            ];
        }
    }
}
?>
