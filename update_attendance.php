<?php
// Start the session
session_start();

// Check if the username is set in the session
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];

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

    // Check if Subject_ID, attendanceDate, and attendance data are set
    if (isset($_POST['Subject_ID']) && isset($_POST['attendanceDate']) && isset($_POST['attendance'])) {
        $subjectID = $_POST['Subject_ID'];
        $attendanceDate = $_POST['attendanceDate'];
        $attendanceData = $_POST['attendance'];

        // Update attendance for each student
        foreach ($attendanceData as $studentID => $status) {
            // Update the attendance for the current student on the specified date
            $sqlUpdate = "UPDATE $subjectID SET `$attendanceDate` = '$status' WHERE Student_ID = '$studentID'";
            $conn->query($sqlUpdate);
        }

        header("Location: attendance_details.php?Subject_ID=" . $subjectID . "");
    } else {
        echo "Subject_ID, attendanceDate, and attendance data are required.";
    }

    // Close the connection
    $conn->close();
} else {
    // Redirect if the username is not set in the session
    header("Location: login.html");
    exit();
}
?>
