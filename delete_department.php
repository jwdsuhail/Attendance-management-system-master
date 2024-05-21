<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["role"]) {
    // Fetch other details from the database based on the username
    $servername = "localhost";
    $username_db = "zaid";
    $password_db = "1234";
    $dbname = "attendance";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['Department_ID'])) {
        $Department_ID = $_GET['Department_ID'];
        $sql = "DELETE FROM department where Department_ID='$Department_ID'";
        $result = $conn->query($sql);

        // Check if the deletion was successful
        if ($result) {
            // Display a success alert using JavaScript
            echo '<script>alert("Department deleted successfully!");</script>';

            // Redirect using JavaScript
            echo '<script>window.location.href = "admin_departments.php";</script>';
            exit();
        } else {
            // Display an error alert if the deletion failed
            echo '<script>alert("Error: Unable to delete department!");</script>';
        }
    }
}
?>
