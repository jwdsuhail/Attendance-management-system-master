<?php
// schedule.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected date
    $selectedDate = $_POST['selectedDate'];
    $Subject_ID = $_POST['Subject_ID'];
    // Validate and sanitize the date (adjust the validation based on your requirements)
    if (!empty($selectedDate)) {
        $formattedDate = date('d-m-Y', strtotime($selectedDate));

        echo $formattedDate;
        echo $Subject_ID;
       
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
            $sql="ALTER TABLE $Subject_ID ADD COLUMN `$formattedDate` VARCHAR(30);";
            $result = $conn->query($sql);
            $sql="SELECT Subject_Name from subjects where Subject_ID= '$Subject_ID'";
$result = $conn->query($sql);
$row= $result->fetch_assoc();
$Name=$row['Subject_Name'];

            $toEmail = "md.zaidd31@gmail.com";
        $subjectName = "Schedule Alert ";
        $message = "$Subject_ID class ( $Name ) class scheduled on $formattedDate";
        $header = "From: Muhammad Zaid";
        mail($toEmail,$subjectName, $message, $header);
        header("Location: attendance_details.php?Subject_ID=" . $subjectID . "");
        
            header("Location: attendance_details.php?Subject_ID=" . $Subject_ID . "");

    } else {
        // Handle the case when the date is not selected
        echo "<script> 
    alert('Please select a date and try again.');
    window.location.href = 'attendance_details.php?Subject_ID=" . $Subject_ID . "';
</script>";

    }
}
?>

