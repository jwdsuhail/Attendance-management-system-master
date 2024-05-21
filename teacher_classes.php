<head>
         <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.0.0/flowbite.min.css" rel="stylesheet" />
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
      justify-content: space-between;
    }
    .grid-item {
            height: 290px;
            width: 290px;
            display: grid;
            grid-template-rows: repeat(4, 1fr);
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
    $sql = "SELECT profile_pic FROM teachers WHERE username = '$username'";
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
                                    <a href="teacher_profile.php">Profile</a>
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
            <a href="teacher.php">
            <span class="icon"><ion-icon name="grid-outline"></ion-icon></span>
            <span class="title">Dashboard</span>
            </a>
        </li>
        <li>
            <a class="active" href="teacher_classes.php">
            <span class="icon"><ion-icon name="pencil-outline"></ion-icon></span>
            <span class="title">Classes</span>
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
  <?php
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
$teachersql= "SELECT Teacher_ID from teachers where Username='$username'";
$result = $conn->query($teachersql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Teacher_ID = $row["Teacher_ID"];
}
$sql = "
SELECT 
    subjects.Subject_ID,
    subjects.Subject_Name,
    subjects.Class,
    subjects.Course_ID,
    courses.Name
FROM
    subjects
JOIN
    courses ON subjects.Course_ID = courses.Course_ID
WHERE
    subjects.Teacher_ID = '$Teacher_ID';

";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$sql2="SELECT * from courses";
$result2 = $conn->query($sql2);

$sql3="SELECT Teacher_ID, Full_Name from teachers";
$result3 = $conn->query($sql3);

echo'
<div style="width:1220px; height:100px; border: 3px solid black; padding:10px;" class="filter-section">
<p class="text-xl">Filter Classes</p>
<div class="grid grid-cols-3">
<div>
<label for="filterSubject">Subject:</label>
    <input type="text" style="width:300px;" id="filterSubject" name="filterSubject" oninput="filterTable()">
</div>
<div>
<label for="filterCourse">Course:</label>
<select style="width:300px;" id="filterCourse" name="filterCourse" onchange="filterTable()">
    <option value="">All Courses</option>';
    
    // Fetch courses from the database and populate the dropdown
    $sqlCourses = "SELECT Course_ID, Name FROM courses";
    $resultCourses = $conn->query($sqlCourses);
    while ($rowCourse = $resultCourses->fetch_assoc()) {
        echo '<option value="' . $rowCourse['Name'] . '">' . $rowCourse['Name'] . '</option>';
    }
echo'
</select>
</div>

<div>
<label for="filterClass">Class:</label>
<select style="width:300px;" id="filterClass" name="filterClass" onchange="filterTable()">
    <option value="">All Classes</option>
    <option value="Year 1">Year 1</option>
    <option value="Year 2">Year 2</option>
    <option value="Year 3">Year 3</option>
</select>

</div>
</div>
<br><br>
';

echo'<center>
<table border="1" style="border-collapse: collapse; width: 100%;">
<tr>
<th style="border: 4px solid black; padding: 8px;" class="text-2xl">ID</th>
<th style="border: 4px solid black; padding: 8px;" class="text-2xl"> Name</th>
<th style="border: 4px solid black; padding: 8px;" class="text-2xl">Class</th>
<th style="border: 4px solid black; padding: 8px;" class="text-2xl">Course</th>
<th style="border: 4px solid black; padding: 8px;" class="text-2xl">Manage</th>
</tr>
';
while($row= $result->fetch_assoc()){
    echo
    '
    <tr>
    <td style="border: 2px solid black; padding: 10px;">' . $row["Subject_ID"] . '</td>
    <td style="border: 2px solid black; padding: 10px;">' . $row["Subject_Name"] . '</td>
    <td style="border: 2px solid black; padding: 10px;">' . $row["Class"] . '</td>
    <td style="border: 2px solid black; padding: 10px;">' . $row["Name"] . '</td>
    <td style="border: 2px solid black; padding: 10px;"><center><a href="manage_class.php?Subject_ID=' . $row['Subject_ID'] . '" class="button inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 items-center">Manage</a></center></td>
    </tr>
    ';
}
} else{
echo"<center><p class='text-2xl'> No classes Set</center></p>";
}
echo'</table>
<br><br>';
?>
<script>
function filterTable() {
        // Get input values
        var filterSubject = document.getElementById("filterSubject").value.toUpperCase();
        var filterCourse = document.getElementById("filterCourse").value.toUpperCase();
        var filterClass = document.getElementById("filterClass").value.toUpperCase();

        // Get the table rows
        var rows = document.querySelectorAll("table tr");

        // Loop through each row and hide/show based on the input values
        for (var i = 1; i < rows.length; i++) {
            var name = rows[i].cells[1].textContent.toUpperCase();
            var course = rows[i].cells[3].textContent.toUpperCase();
            var classValue = rows[i].cells[2].textContent.toUpperCase();

            if (name.includes(filterSubject) && course.includes(filterCourse) && classValue.includes(filterClass)) {
                rows[i].style.display = "";
            } else {
                rows[i].style.display = "none";
            }
        }
    }
</script>

</div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>