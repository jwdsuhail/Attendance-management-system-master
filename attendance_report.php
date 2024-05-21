<head>
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

        <title> Attendance Management System </title>
    </head>
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
    .grid-item {
            height: 290px;
            width: 290px;
            display: grid;
            grid-template-rows: repeat(3, 1fr);
            border: 4px solid #000; /* Adjust the border color */
            border-radius : 25px ;
        }
    .grid-item:hover{
      background-color:#4169e1 ; 
      } 

        .grid-item p {
            text-align: center;
            font-size: 4xl;
        }

        .grid-item b {
            font-size: 2xl;
        }
    </style>
  <body>
    <?php
    // Start the session
    session_start();

    // Check if session variables are set
    if (isset($_SESSION['username']) && isset($_SESSION['role'])) {
        $username = $_SESSION['username'];
        $role = $_SESSION['role'];
        // Fetch profile picture from the database
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

    // Prepare and execute the SQL query to fetch the profile picture
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
                                    <a href="profile.php">Profile</a>
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
    

    } else {
        // Redirect if session variables are not set
        header("Location: login.php");
        exit();
    }
    ?>
    
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
            <a href="admin.php">
            <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
            <span class="title">Dashboard</span>
            </a>
        </li>
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
    if(isset($_GET['student_id'])) {
        $Student_ID = $_GET['student_id'];
        $Subject_ID=$_GET['subject_id'];
    // Prepare and execute the SQL query to fetch other details  
  
  $sql="SELECT * FROM students WHERE Student_ID ='$Student_ID'";
  $result = $conn->query($sql);
  $row= $result->fetch_assoc();
  $fullName=$row['Full_Name'];
  $course_ID=$row['Course_ID'];
  $profilePictureBinary = $row['Profile_Pic'];

  // Convert binary data to base64
  $profilePictureBase64 = base64_encode($profilePictureBinary);

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

echo
'
<center>
<p class="text-2xl">Attendance Report for <b>'.$fullName.'</b></p>
<br>
<div style="height:520px; width:900px;" class="border border-gray-200">
<br>
<img style="height:260px; width:260px;" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"/>
<div class="grid grid-cols-2">
<div class="p-5">
        <label for="student_ID">Student ID:</label><br>
        <input type="text" id="student_ID" name="student_ID" style="width:330px;" value="' . $Student_ID . '" disabled>
        <br><br>

        <label for="subject_ID">Subject ID:</label><br>
        <input type="text" id="subject_ID" name="subject_ID" style="width:330px;" value="' . $Subject_ID . '" disabled>
        <br><br>

    
</div>
<div class="p-5">
<label for="course">Course:</label><br>
<input type="text" id="course" name="course" style="width:330px;" style="width:330px;" value="' . $course . '" disabled>
<br><br>

        <label for="Subject_Name">Subject Name</label><br>
        <input type="text" id="Subject_Name" name="Subject_Name" style="width:330px;" value="' . $Subject_Name . '" disabled>
        <br><br>

</div>
</div>
<br><br>';
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
        echo '<br><div class="chart-container" style="border: 2px solid black;">';
        
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
}}
 ?>
</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>