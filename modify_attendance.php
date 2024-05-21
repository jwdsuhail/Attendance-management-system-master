<html><head><style>
 input[type="radio"] {
            width: 25px;
            height: 25px;
        }

</style></head></html>

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
    // Prepare and execute the SQL query to fetch other details
    $sql = "SELECT role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch and display the user details
        $row = $result->fetch_assoc();
    if ($row["role"] == "admin") {
        $sql = "SELECT Profile_Pic FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the profile picture path
        $row = $result->fetch_assoc();
        
        $profilePictureBinary = $row['Profile_Pic'];

        // Convert binary data to base64
        $profilePictureBase64 = base64_encode($profilePictureBinary);

        
        // Display the profile picture
        echo '<div class="navbar-horizontal">
                <ul>
                    <li>
                        <a href="profile.php">
                            <div class="grid grid-cols-2">
                                <span><img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-12 h-12 rounded-full cursor-pointer" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"></span>
                                <div class="grid grid-rows-3">
                                    <div></div>
                                    <span href="profile.php">Profile</span>
                                    <div></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>';
    } 
        $sql = "SELECT * FROM admin WHERE username = '$username'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {

    } 
    elseif($row["role"] == "teacher") {
        
        $sql = "SELECT Profile_Pic FROM teachers WHERE username = '$username'";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            // Fetch the profile picture path
            $row = $result->fetch_assoc();
            
            $profilePictureBinary = $row['Profile_Pic'];
    
            // Convert binary data to base64
            $profilePictureBase64 = base64_encode($profilePictureBinary);
    
            
            // Display the profile picture
            echo '<div class="navbar-horizontal">
                    <ul>
                        <li>
                            <a href="profile.php">
                                <div class="grid grid-cols-2">
                                    <span><img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-12 h-12 rounded-full cursor-pointer" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"></span>
                                    <div class="grid grid-rows-3">
                                        <div></div>
                                        <span href="profile.php">Profile</span>
                                        <div></div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>';
        } 
    elseif($row["role"] == "student") {
        $sql = "SELECT Profile_Pic FROM students WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the profile picture path
        $row = $result->fetch_assoc();
        
        $profilePictureBinary = $row['Profile_Pic'];

        // Convert binary data to base64
        $profilePictureBase64 = base64_encode($profilePictureBinary);

        
        // Display the profile picture
        echo '<div class="navbar-horizontal">
                <ul>
                    <li>
                        <a href="profile.php">
                            <div class="grid grid-cols-2">
                                <span><img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-12 h-12 rounded-full cursor-pointer" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"></span>
                                <div class="grid grid-rows-3">
                                    <div></div>
                                    <span href="profile.php">Profile</span>
                                    <div></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>';
    } 
    }

    $conn->close();
    }
}
}
else {
    // Redirect if the username is not set in the session
    header("Location: login.html");
    exit();
}}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
    <title>Attendance Management System</title>
    <style>
  body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .navbar-vertical {
      height: 100%;
      width: 260px;
      background-color: #4169e1;
      position: fixed;
      left: 0;
      top: 0;
      overflow-x: hidden;
      padding-top: 20px;
       z-index: 1;
    }

    .navbar-vertical a {
      padding: 20px;
      text-decoration: none;
      font-size: 20px;
      color: white;
      display: block;
    }

    .navbar-vertical a:hover {
      background-color: #D4AF37;
    }
    .active {
      background-color: #D4AF37;
    }
    .navbar-vertical li {
      list-style: none; 
    }

    .navbar-horizontal {
      background-color: #4169e1;
      overflow: hidden;
      position: fixed;
      top: 0;
      width: 100%;
      padding-top: 1px;
      padding-bottom: 1px;
      padding-right: 15px;
    }

    .navbar-horizontal a {
      float: left;
      display: block;
      color: white;
      text-align: center;
      padding: 10px;
      text-decoration: none;
      font-size: 20px;
      color: white;
      display: block;
    }

 .navbar-horizontal li {
      list-style: none; 
      float: right;
    }
    .content {
      margin-left: 265px;
      padding: 20px;
      margin-top: 70px; /* Adjust this value to leave space for the horizontal navbar */
    }
    </style>
         <script>
        // Function to filter columns based on the selected month
        function filterColumns() {
            var selectedMonth = document.getElementById('month').value;
            var table = document.getElementById('attendanceTable');
            var headerRow = table.rows[0];

            // Loop through each cell in the header row starting from the third cell
            for (var j = 2; j < headerRow.cells.length; j++) {
                var columnName = headerRow.cells[j].textContent || headerRow.cells[j].innerText;

                // Show or hide the column based on the selected month
                if (selectedMonth === 'all' || columnName.includes(selectedMonth)) {
                    headerRow.cells[j].style.display = '';
                    // Loop through each row and show/hide the corresponding cell
                    for (var i = 1; i < table.rows.length; i++) {
                        table.rows[i].cells[j].style.display = '';
                    }
                } else {
                    headerRow.cells[j].style.display = 'none';
                    // Loop through each row and show/hide the corresponding cell
                    for (var i = 1; i < table.rows.length; i++) {
                        table.rows[i].cells[j].style.display = 'none';
                    }
                }
            }
        }
    </script>
</head>
<body>
<div class="navbar-vertical">
    <ul>
        <li>
            <div style="color: white; font-size:30px;">
            <span class="icon"><ion-icon name="flash-outline"></ion-icon></span>
            <span class="title"><b>Bolton AMS</b></span>
            </div>
        </li>
        <br>
        <li>
            <a class="active" href="javascript:history.go(-1);">
            <ion-icon name="chevron-back-outline"></ion-icon>
            <span class="title">Back</span>
            </a>
        </li>
        <li>
            <a href="index.php">
            <ion-icon name="log-out-outline"></ion-icon>
            <span class="title">Log Out</span>
            </a>
        </li>
    </ul>
    </div>
<div class="content">
  <!-- Your main content goes here -->
  <?php

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

    // Check if Subject_ID and attendanceDate are set
    if (isset($_POST['Subject_ID']) && isset($_POST['attendanceDate'])) {
        $subjectID = $_POST['Subject_ID'];
        $attendanceDate = $_POST['attendanceDate'];

        // Fetch student details and attendance status for the selected date
        $sql = "SELECT Student_ID, Full_Name, `$attendanceDate` FROM $subjectID";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo' <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Modify Attendance</title>
            </head>
            <body>
                <p class="text-3xl">Modify Attendance for<b> ' . $attendanceDate . '</b></p>
                <form action="update_attendance.php" method="post">
                    <input type="hidden" name="Subject_ID" value="' . $subjectID . '">
                    <input type="hidden" name="attendanceDate" value="' . $attendanceDate . '">
                    <br>
                    <center>
                    <table border="1" style="padding:8px; border:2px solid black;">
                        <tr class="text-2xl" style="padding:8px;">
                            <th style="padding:8px;">Student ID</th>
                            <th style="padding:8px;">Student Name</th>
                            <th style="padding:8px;">Attendance Status</th>
                        </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr style="padding:8px;">
                    <td style="padding:8px;" class="text-xl">' . $row['Student_ID'] . '</td>
                    <td style="padding:8px; font-weight: bold;" class="text-xl">' . $row['Full_Name'] . '</td>
                    <td style="padding:8px;" class="text-xl">
                        <input type="radio" name="attendance[' . $row['Student_ID'] . ']" value="Present" id="present_' . $row['Student_ID'] . '" ' . ($row[$attendanceDate] == "Present" ? 'checked' : '') . '> <label for="present_' . $row['Student_ID'] . '">Present</label> &nbsp&nbsp
                        <input type="radio" name="attendance[' . $row['Student_ID'] . ']" value="Absent" id="absent_' . $row['Student_ID'] . '" ' . ($row[$attendanceDate] == "Absent" ? 'checked' : '') . '> <label for="absent_' . $row['Student_ID'] . '">Absent</label> &nbsp&nbsp
                        <input type="radio" name="attendance[' . $row['Student_ID'] . ']" value="Late" id="late_' . $row['Student_ID'] . '" ' . ($row[$attendanceDate] == "Late" ? 'checked' : '') . '> <label for="late_' . $row['Student_ID'] . '">Late</label> &nbsp&nbsp
                    </td>
                </tr>';
        }

        echo '</table>
                <br>
                <input type="submit" class="button inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 items-center" value="Update Attendance">
                </center>
                </form>
            </body>
            </html> ';
        } else {
            echo 'No data found for the specified Subject_ID and attendanceDate.';
        }
    } else {
        echo "Subject_ID and attendanceDate are required.";
    }

    // Close the connection
    $conn->close();
} else {
    // Redirect if the username is not set in the session
    header("Location: login.html");
    exit();
}
?>

</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
