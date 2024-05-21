<!DOCTYPE html>
<html>
<body>

<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["role"])
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $teacher_ID = $_POST["Teacher_ID"];
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $department = $_POST["department"];
        $password = ($_POST["password"]);
        $conpassword = ($_POST["conpassword"]); 
        $age = $_POST["age"];
        $phone = $_POST["phone"];
        $year = $_POST["year"];
        $tusername = $_POST["username"];
        
        $ciphering="AES-128-CTR";
        $option=0;
        $ecryption_iv="1234567890123456";
        $encryption_key="team5";
        $encryption= openssl_encrypt($password, $ciphering, $ecryption_iv, $option, $encryption_key);

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

        // Prepare and execute the SQL query to insert data into the users table
        $sql = "INSERT INTO users VALUES ('$tusername','$encryption','teacher')";
        $result = $conn->query($sql);

        // Prepare and execute the SQL query to insert data into the teachers table
        $sql = "INSERT INTO teachers(Teacher_ID, Full_Name, Age, Email, Phone, Date_of_Joining, Department_ID,Username) 
                VALUES ('$teacher_ID','$fullName','$age','$email','$phone','$year','$department','$tusername')";
        $result = $conn->query($sql);

    

        // File upload handling
        $image = $_FILES["profile_pic"]["tmp_name"];

        // Check if file upload is successful
        if ($_FILES["profile_pic"]["error"] !== UPLOAD_ERR_OK) {
            echo '<script>alert("File upload failed.");
            window.location.href = "add_teachers.php";
            </script>';
            exit();
        }

        // Read the file content and convert it to LONG BLOB binary form
        $imageData = file_get_contents($image);
        $updateSql = "UPDATE teachers SET Profile_Pic = ? WHERE Username = '$tusername'";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("s", $imageData);
        $updateStmt->execute();
        $updateStmt->close();
        if ($result) {
            // JavaScript alert after successful insertion
            echo '<script>alert("Teacher account successfully created.");';
            echo 'window.location.href = "admin_teachers.php";';
            echo '</script>';
            exit();
        } else {
            echo '<script>alert("Error: ' . $conn->error . '");
            window.location.href = "add_teachers.php";
            </script>';
        }
    } else {
        echo 'Failed to get details from the form';
    }
} else {
    header("Location: index.php");
}
?>
</body>
</html>
