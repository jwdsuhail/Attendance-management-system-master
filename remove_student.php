<!DOCTYPE html>
<html>
<body>

<?php
session_start();
if (isset($_SESSION["username"]) && $_SESSION["role"])
{
    if(isset($_GET['Student_ID'])) 
    {
        $Student_ID = $_GET['Student_ID'];
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
        $sql="SELECT Username FROM students WHERE Student_ID = '$Student_ID'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $susername=$row['Username'];
            $sql2="DELETE FROM users WHERE Username='$susername'";
            $result2 = $conn->query($sql2);

            $sql3="DELETE FROM students WHERE Student_ID='$Student_ID'";
            $result3 = $conn->query($sql3);

            if ($result2 && $result3) {
                // JavaScript alert after successful deletion
                echo '<script>alert("Student account successfully deleted.");';
                echo 'window.location.href = "delete_students.php";';
                echo '</script>';
                exit();
            } else {
                echo "Error deleting data: " . $conn->error;
            }
        }
    }    
}
?>

</body>
</html>
