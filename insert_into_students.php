<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["role"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $student_ID = $_POST["student_ID"];
        $fullName = $_POST["fullName"];
        $email = $_POST["email"];
        $course = $_POST["course"];
        $password = ($_POST["password"]);
        $conpassword = ($_POST["conpassword"]);
        $age = $_POST["age"];
        $phone = $_POST["phone"];
        $class = $_POST["class"];
        $susername = $_POST["username"];

        // Check if passwords match
        if ($password !== $conpassword) {
            echo "<script>alert('Passwords don\'t match. Please try again.'); window.location.href='add_students.php';</script>";
            exit();
        }

        $ciphering = "AES-128-CTR";
        $option = 0;
        $ecryption_iv = "1234567890123456";
        $encryption_key = "team5";
        $encryption = openssl_encrypt($password, $ciphering, $ecryption_iv, $option, $encryption_key);

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

        // Prepare and execute the SQL query to insert student record
        $sql = "INSERT INTO users Values('$susername','$encryption','student')";
        $result = $conn->query($sql);

        $sql = "INSERT INTO students(Student_ID, Full_Name, Age, Email, Phone, Class, Course_ID,Username) 
        VALUES ('$student_ID','$fullName','$age','$email','$phone','$class','$course','$susername')";
        $result = $conn->query($sql);

        $sql2 = "SELECT Subject_ID FROM subjects Where Class='$class' and Course_ID='$course'";
        $result2 = $conn->query($sql2);

        while ($row2 = $result2->fetch_assoc()) {
            $subject = $row2["Subject_ID"];
            $sql = "INSERT into $subject (Student_ID, Full_Name) VALUES ('$student_ID','$fullName')";
            $result = $conn->query($sql);
        }

        $image = $_FILES["profile_pic"]["tmp_name"];

        // Check if file upload is successful
        if ($_FILES["profile_pic"]["error"] !== UPLOAD_ERR_OK) {
            echo "<script>alert('File upload failed'); window.location.href='your_previous_page.php';</script>";
            exit();
        }

        // Read the file content and convert it to LONG BLOB binary form
        $imageData = file_get_contents($image);
        $updateSql = "UPDATE students SET Profile_Pic = ? WHERE Username = '$susername'";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("s", $imageData);
        $updateStmt->execute();
        $updateStmt->close();

        // Display success alert and redirect
        echo "<script>alert('Record successfully added'); window.location.href='admin_students.php';</script>";
        exit();
    } else {
        echo 'Failed to get details from the form';
    }
} else {
    header("Location: index.php");
}
?>
