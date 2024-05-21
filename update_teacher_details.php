<?php
session_start();

if (isset($_SESSION['username']) && isset($_GET['Teacher_ID'])) {
    $Teacher_ID = $_GET['Teacher_ID'];
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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fullName = $_POST["fullName"];
        $age = $_POST["age"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $tusername = $_POST["username"];
        $password = $_POST["password"];
        $year = $_POST["year"];
        $conpassword = $_POST["conpassword"];

        $ciphering = "AES-128-CTR";
        $option = 0;
        $ecryption_iv = "1234567890123456";
        $encryption_key = "team5";
        $encryption = openssl_encrypt($password, $ciphering, $ecryption_iv, $option, $encryption_key);

        if ($password == $conpassword) {
            $sql = "SELECT Username FROM teachers WHERE Teacher_ID='$Teacher_ID'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $tempusername = $row["Username"];

            $sql = "UPDATE users SET Username='$tusername', Password='$encryption' WHERE role='teacher' AND Username='$tempusername'";
            $result = $conn->query($sql);

            // SQL query to update teacher details
            $sqlUpdateTeacher = "UPDATE teachers SET
                             Full_Name = '$fullName',
                             Age = '$age',
                             Phone = '$phone',
                             Email = '$email',
                             Username = '$tusername',
                             Date_of_Joining = '$year'
                             WHERE Teacher_ID = '$Teacher_ID'";
            $resultUpdateTeacher = $conn->query($sqlUpdateTeacher);

            if ($_FILES["Profile_Pic"]["size"] > 0) {
                $image = $_FILES["Profile_Pic"]["tmp_name"];
                $imageData = file_get_contents($image);

                $updateSql = "UPDATE teachers SET Profile_Pic = ? WHERE Username = '$tusername'";
                $updateStmt = $conn->prepare($updateSql);

                // Use 'b' for a BLOB data type
                $updateStmt->bind_param("s", $imageData);
                $updateStmt->execute();
                $updateStmt->close();
            }

            // Display success message as an alert and reload the same page
            echo '<script>alert("Teacher account successfully updated.");';
            echo 'window.location.href = "modify_teacher.php?Teacher_ID=' . $Teacher_ID . '";';
            echo '</script>';
            exit();
        } else {
            // Display password mismatch error message as an alert
            echo '<script>alert("Passwords do not match. Please try again.");
            window.location.href = "modify_teacher.php?Teacher_ID=' . $Teacher_ID . '";
            </script>';
        }
    }
}
?>
