<?php
// Replace with your database credentials
session_start();
$servername = "localhost";
$username_db = "zaid";
$password_db = "1234";
$database = "attendance";

// Create a connection to the database
$conn = new mysqli($servername, $username_db, $password_db, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $role = $_POST["role"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $_SESSION["role"] = $role;
    $_SESSION["username"] = $username;
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM users WHERE role = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $role, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // User found, check the role and then verify the password
        $pass = $row["Password"];
        $ciphering = "AES-128-CTR";
        $option = 0;
        $decryption_iv = "1234567890123456";
        $decryption_key = "team5";

        $decryption = openssl_decrypt($pass, $ciphering, $decryption_iv, $option, $decryption_key);

        if ($role == $row['Role']) {
            if ($password === $decryption) {
                // User authenticated, you can redirect here
                if ($role == 'admin') {
                    echo "<script>alert('Login Successful'); window.location.href='admin.php';</script>";
                    exit();
                } elseif ($role == 'teacher') {
                    echo "<script>alert('Login Successful'); window.location.href='teacher.php';</script>";
                    exit();
                } elseif ($role == 'student') {
                    echo "<script>alert('Login Successful'); window.location.href='student.php';</script>";
                    exit();
                }
            } else {
                // Incorrect password, display alert and redirect to login page
                echo "<script>alert('Incorrect Password'); window.location.href='login.php';</script>";
                exit();
            }
        } else {
            // Invalid role, display alert and redirect to login page
            echo "<script>alert('Invalid Credential. Please try again.'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        // Invalid credentials, display alert and redirect to login page
        echo "<script>alert('Invalid credentials. Please try again.'); window.location.href='login.php';</script>";
        exit();
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
