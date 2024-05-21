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
    $sql ="SELECT Role from users where Username ='$username'";
    $result = $conn->query($sql); 
    $row= $result->fetch_assoc();
    $tableName ="";
    if ($row["Role"] == "Teacher" || $row["Role"] == "teacher" ) {
      $tableName="teachers";
    }
    elseif($row["Role"] == "Student" || $row["Role"] == "student"){
      $tableName= "students";
    }
    elseif($row["Role"] == "Admin" || $row["Role"] == "admin" ){
      $tableName= "admin";
    }
    $sql = "SELECT profile_pic FROM $tableName WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the profile picture path
        $row = $result->fetch_assoc();
        $profilePictureBinary = $row['profile_pic'];

        // Convert binary data to base64
        $profilePictureBase64 = base64_encode($profilePictureBinary);
        // Display the profile picture
        echo '<div class="navbar-horizontal">
                <ul>
                    <li>
                        <a>
                            <div class="grid grid-cols-2">
                                <span><img id="avatarButton" type="button" data-dropdown-toggle="userDropdown" data-dropdown-placement="bottom-start" class="w-12 h-12 rounded-full cursor-pointer" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"></span>
                                <div class="grid grid-rows-3">
                                    <div></div>
                                    <a href="student_profile.php">Profile</a>
                                    <div></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>';
    } else {
        echo "Profile picture not found.";
    }
  
    $conn->close();
    }
else {
    // Redirect if the username is not set in the session
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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


        .cell {
            width: 20px;
            height: 20px;
            display: inline-block;
            border: 1px solid black;
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

      if(isset($_GET['Subject_ID'])) {
        $Subject_ID = $_GET['Subject_ID'];
        $Student_ID = $_GET['Student_ID'];
  
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
      $sql="SELECT * FROM students WHERE Student_ID ='$Student_ID'";
  $result = $conn->query($sql);
  $row= $result->fetch_assoc();
  $fullName=$row['Full_Name'];
  $course_ID=$row['Course_ID'];
  
  $sql2 = "SELECT Subject_Name FROM subjects Where Subject_ID='$Subject_ID'";
  $result2 = $conn->query($sql2);
  $row2 = $result2->fetch_assoc();
  $Subject_Name = $row2["Subject_Name"];
  
  $sql3 = "SELECT * from courses where Course_ID='$course_ID'";
  $result3 = $conn->query($sql3);
  $row3 = $result3->fetch_assoc();
  $course=$row3['Name'];
  $sql4 = "SELECT * FROM $Subject_ID where Student_ID='$Student_ID'";
        $result4 = $conn->query($sql4);

        // Check if there are rows
        if ($result4->num_rows > 0) {
            // Initialize an array to store data
            $studentData = [];

            // Fetch rows and store in the array
            while ($row4 = $result4->fetch_assoc()) {
                $student_ID = $row['Student_ID'];
                $StudentData[$Student_ID] = $row4;
            }

      $sql="SELECT * from subjects where Subject_ID='$Subject_ID'";
      $result = $conn->query($sql);
      $row = $result->fetch_assoc();
      echo'
      <center><div style="border: 2px solid black;" class="p-2"><p class="text-3xl"><b>'.$row['Subject_Name'].'</b></p></div></center><br>
      ';

      echo'
      <div style="margin-top: 20px; border:2px solid black; width:400px;" class="p-4">
    <label for="month">Select Month:</label>
    <select style="width:300px;" id="month" onchange="filterColumns()">
        <option value="all">All Months</option>
        <option value="10">October 2023</option>
        <option value="11">November 2023</option>
        <option value="12">December 2023</option>
        <option value="01">January 2023</option>
    </select>
</div><br>
      ';

      $sql2 = "SELECT * FROM $Subject_ID where Student_ID='$Student_ID'";
        $result2 = $conn->query($sql2);

        if ($result2->num_rows > 0) {
            // Display details in a tabular form
            echo '<table id="attendanceTable" border="1" style=" display: block; overflow-x:auto; whitespace:nowrap; border-collapse: collapse; width: 100%;">
                    <tr>';
            
                    while ($fieldinfo = $result2->fetch_field()) {
                        $columnNames[] = $fieldinfo->name;
                    }
                
                    // Remove the first two columns
                    array_shift($columnNames);
                    array_shift($columnNames);
                
                    // Sort the remaining column names in ascending order
                    $dateColumns = [];
    foreach ($columnNames as $columnName) {
        $dateColumns[$columnName] = DateTime::createFromFormat('d-m-Y', $columnName)->format('Y-m-d');
    }

    asort($dateColumns);

                
                    // Display the first two columns manually
                    echo '<th style="border: 4px solid black; padding: 8px;" class="text-l">Student ID</th>';
                    echo '<th style="border: 4px solid black; padding: 8px;" class="text-l">Student Name</th>';
                
                    // Loop through the sorted column names to display them
                    foreach ($dateColumns as $columnName => $formattedDate) {
                        echo '<th style="border: 4px solid black; padding: 8px;" class="text-l">' . $columnName . '</th>';
                    }
                
                    echo '</tr>';
                
                    while ($row2 = $result2->fetch_assoc()) {
                        echo '<tr>';
                        
                        // Display the first two columns manually
                        echo '<td style="border: 2px solid black; padding: 10px;">' . $row2['Student_ID'] . '</td>';
                        echo '<td style="border: 2px solid black; padding: 10px;">' . $row2['Full_Name'] . '</td>';
                
                        // Loop through the sorted date columns dynamically
                        foreach ($dateColumns as $columnName => $formattedDate) {
                            // Set cell color based on the value
                            $value = $row2[$columnName];
                            $cellColor = '';
                            if ($value === 'Present') {
                                $cellColor = 'background-color: lightgreen;';
                            } elseif ($value === 'Absent') {
                                $cellColor = 'background-color: lightcoral;';
                            } elseif ($value === 'Late') {
                                $cellColor = 'background-color: #e9f542;';
                            }
                
                            // Echo the table cell with the specified style
                            echo '<td style="border: 2px solid black; padding: 10px; ' . $cellColor . '">' . $value . '</td>';
                        }
                
                        echo '</tr>';
                    }
                
                    echo '</table>';
        } else {
            echo 'No data found for the specified Subject_ID.';
        }
        
 $sql = "SELECT * FROM $Subject_ID";
        $result = $conn->query($sql);

        // Check if there are rows
        if ($result->num_rows > 0) {
            // Initialize an array to store data
            $studentData = [];

            // Fetch rows and store in the array
            while ($row = $result->fetch_assoc()) {
                $student_ID = $row['Student_ID'];
                $studentData[$student_ID] = $row;
            }

        }}
        }
    }
    
    $sql="SELECT * FROM students WHERE Student_ID ='$Student_ID'";
  $result = $conn->query($sql);
  $row= $result->fetch_assoc();
  $fullName=$row['Full_Name'];
  $course_ID=$row['Course_ID'];


  $sql2 = "SELECT Subject_Name FROM subjects Where Subject_ID='$Subject_ID'";
  $result2 = $conn->query($sql2);
  $row2 = $result2->fetch_assoc();
  $Subject_Name = $row2["Subject_Name"];
  
  $sql3 = "SELECT * from courses where Course_ID='$course_ID'";
  $result3 = $conn->query($sql3);
  $row3 = $result3->fetch_assoc();
  $course=$row3['Name'];
  $sql4 = "SELECT * FROM $Subject_ID where Student_ID='$Student_ID'";
        $result4 = $conn->query($sql4);

        // Check if there are rows
        if ($result4->num_rows > 0) {
            // Initialize an array to store data
            $studentData = [];

            // Fetch rows and store in the array
            while ($row4 = $result4->fetch_assoc()) {
                $student_ID = $row['Student_ID'];
                $StudentData[$Student_ID] = $row4;
            }

// Modify this line to exclude the first two columns
$sqlcolumns="SHOW COLUMNS FROM `$Subject_ID`";
$resultColumns = $conn->query($sqlcolumns);
$columns = [];
    
        if ($resultColumns->num_rows > 0) {
            while ($rowColumn = $resultColumns->fetch_assoc()) {
                $columns[] = $rowColumn['Field'];
            }
            
            // Ignore the first two columns
            $columnsToDisplay = array_slice($columns, 2);
    
            // Sort the remaining columns by date
            // Assuming your date column is named 'date_column', modify it accordingly
            usort($columnsToDisplay, function ($a, $b) {
                // Convert date strings to DateTime objects for comparison
                $dateA = DateTime::createFromFormat('d-m-Y', $a);
                $dateB = DateTime::createFromFormat('d-m-Y', $b);

                // Compare years first
                $yearComparison = $dateA->format('Y') - $dateB->format('Y');
                if ($yearComparison !== 0) {
                    return $yearComparison;
                }

                // Compare months second
                $monthComparison = $dateA->format('m') - $dateB->format('m');
                if ($monthComparison !== 0) {
                    return $monthComparison;
                }

                // Compare days last
                return $dateA->format('d') - $dateB->format('d');
            });

        }

if (isset($StudentData)) {
    foreach ($StudentData as $Student_ID => $data) {
        // Display the student information and the pie chart
        echo '<br><div class="chart-container" style="border: 2px solid black; height:490px; width:900px;">';
        try{
        // Count attendance values for each student
        $presentCount = 0;
        $absentCount = 0;
        $lateCount = 0;

        // Assuming your attendance values are "Present", "Absent", and "Late"
        foreach ($data as $columnName => $value) {
            if ($value === "Present") {
                $presentCount++;
            } elseif ($value === "Absent") {
                $absentCount++;
            } elseif ($value === "Late") {
                $lateCount++;
            }
        }

        // Display the even smaller pie chart
        echo "
        <div class='grid grid-cols-2 gap-4'>
        <div>
        <canvas id='chart_$Student_ID'></canvas>
        </div><div class='flex grid grid-rows-3 gap-3' style='padding:10px;'><div></div><div class='grid grid-cols-2' style='text-align:left; padding:10px;'>";
        // Display the student information
        $total = $presentCount + $absentCount + $lateCount;
        $presentPercent = round(($presentCount / $total) * 100, 2);
        $absentPercent = round(($absentCount / $total) * 100, 2);
        $latePercent = round(($lateCount / $total) * 100, 2);
        if ($presentPercent < 70) {
            
            $toEmail="md.zaidd31@gmail.com";
            $subjectName = "Attendance Alert ";
            $message="Your attendance has fallen below 70%";
            $header="From : Muhammad Zaid";
            mail($toEmail, $subjectName, $message, $header);
        }

        echo "
        <div>
        <input style='height:30px;' value='Total Number of days'><br><br>
        <input style='height:30px;' value='Days Present:'><br><br>
        <input style='height:30px;' value='Present Percentage:'><br><br>
        <input style='height:30px;' value='Days Absent:'><br><br>
        <input style='height:30px;' value='Absent Percentage:'><br><br>
        <input style='height:30px;' value='Days Late:'><br><br>
        <input style='height:30px;' value='Late Percentage:'><br><br>
        </div>
        <div>
        <input type='text' value='$total' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='$presentCount' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='{$presentPercent}%' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='$absentCount ' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='{$absentPercent}%' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='$lateCount' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        <input type='text' value='{$latePercent}%' disabled style='height:30px; width:200px; font-weight: bold;'><br><br>
        </div>";
        echo"</div><div></div></div></div>";
        
        echo '</div>';
    } catch (DivisionByZeroError $e) {
        echo 'No Attendance Data Found Error generating pie chart for Student ID: ' . $student_ID;
    }
        // Display the JavaScript code for each chart inside the loop
        echo '<script>';
        echo "
            document.addEventListener('DOMContentLoaded', function () {
                var ctx_$Student_ID = document.getElementById('chart_$Student_ID').getContext('2d');
                var chart_$Student_ID = new Chart(ctx_$Student_ID, {
                    type: 'pie',
                    data: {
                        labels: ['Present', 'Absent', 'Late'],
                        datasets: [{
                            data: [$presentCount, $absentCount, $lateCount],
                            backgroundColor: ['#00ff00', '#ff0000', '#ffff00'],
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                        },
                        legend: {
                            display: true,
                        }
                    }
                });
            });
            </script><br><br>
        ";
        $tableName = $Subject_ID;
        $resultColumns = $conn->query("SHOW COLUMNS FROM $tableName");
        $columns = [];
    
        if ($resultColumns->num_rows > 0) {
            while ($rowColumn = $resultColumns->fetch_assoc()) {
                $columns[] = $rowColumn['Field'];
            }
            
            // Ignore the first two columns
            $columnsToDisplay = array_slice($columns, 2);
    
            // Sort the remaining columns by date
            // Assuming your date column is named 'date_column', modify it accordingly
            usort($columnsToDisplay, function ($a, $b) {
                // Convert date strings to DateTime objects for comparison
                $dateA = DateTime::createFromFormat('d-m-Y', $a);
                $dateB = DateTime::createFromFormat('d-m-Y', $b);

                // Compare years first
                $yearComparison = $dateA->format('Y') - $dateB->format('Y');
                if ($yearComparison !== 0) {
                    return $yearComparison;
                }

                // Compare months second
                $monthComparison = $dateA->format('m') - $dateB->format('m');
                if ($monthComparison !== 0) {
                    return $monthComparison;
                }

                // Compare days last
                return $dateA->format('d') - $dateB->format('d');
            });

        }
    }
}
        }

    
    ?>

    

</div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>