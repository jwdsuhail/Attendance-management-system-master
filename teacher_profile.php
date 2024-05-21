<?php
// Start the session
session_start();
error_reporting(E_ERROR | E_PARSE);

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
    if ($row["role"] == "teacher") {
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
                                    <span href="teacher_profile.php">Profile</span>
                                    <div></div>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>';
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
    <title>User Profile</title>
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
      // Prepare and execute the SQL query to fetch other details
    $sql = "SELECT role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch and display the user details
        $row = $result->fetch_assoc();
    if ($row["role"] == "teacher") {
        $sql= "SELECT Teacher_ID from teachers where Username = '$username'";
        $result = $conn->query($sql);
        $row= $result->fetch_assoc();
        $Teacher_ID= $row["Teacher_ID"];

        $sql="SELECT * FROM teachers WHERE Teacher_ID = '$Teacher_ID'";
        $result = $conn->query($sql);
        $row= $result->fetch_assoc();
        $fullName=$row['Full_Name'];
        $age=$row['Age'];
        $phone=$row['Phone'];
        $email=$row['Email'];
        $year=$row['Date_of_Joining'];
        $tusername=$row['Username'];
        $Department_ID=$row['Department_ID'];
        $profilePictureBinary = $row['Profile_Pic'];
      
      
        // Convert binary data to base64
        $profilePictureBase64 = base64_encode($profilePictureBinary);
      
        $sql="SELECT Username from teachers where Teacher_ID='$Teacher_ID'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $sql="SELECT Password from users where Username='" . $row['Username'] . "'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $password=$row['Password'];
        $ciphering="AES-128-CTR";
              $option=0;
              $decryption_iv="1234567890123456";
              $decryption_key="team5";
              $decryption= openssl_decrypt($password, $ciphering, $decryption_iv, $option, $decryption_key);
      
        $sql2 = "SELECT Subject_ID, Subject_Name FROM subjects Where Teacher_ID='$Teacher_ID'";
        $result2 = $conn->query($sql2);
        
        $sql3 = "SELECT Department_Name from department where Department_ID='$Department_ID'";
        $result3 = $conn->query($sql3);
        $row3 = $result3->fetch_assoc();
        $department=$row3['Department_Name'];
      echo
      '
      <center>
      <div style="height:800px; width:900px;" class="border border-gray-200">
      <br>
      <form action="update_teacher_details.php?Teacher_ID=' . $Teacher_ID . '" method="POST" enctype="multipart/form-data">
      <img style="height:260px; width:260px;" src="data:image/jpeg;base64,' . $profilePictureBase64 . '"/>
      <br>
      <input type="file" name="Profile_Pic" accept="image/*">
      <div class="grid grid-cols-2">
      <div class="p-5">
              <label for="Teacher_ID">Teacher ID:</label><br>
              <input type="text" id="Teacher_ID" name="Teacher_ID" style="width:330px;" value="' . $Teacher_ID . '" disabled>
              <br><br>
      
              <label for="fullName">Full Name:</label><br>
              <input type="text" id="fullName" name="fullName" style="width:330px;" value="' . $fullName . '" required>
              <br><br>
      
              <label for="email">Email:</label><br>
              <input type="email" id="email" name="email" style="width:330px;" value="' . $email . '" required>
              <br><br>
      
              <label for="course">Department:</label><br>
              <input type="text" id="department" name="department" style="width:330px;" style="width:330px;" value="' . $department . '" disabled>
      <br><br>
      
      <label for="course">Password:</label><br>
              <input type="text" id="password" name="password" style="width:330px;" style="width:330px;" value="' . $decryption . '" required>
      <br><br>
      
      </div>
      <div class="p-5">
              <label for="age">Age:</label><br>
              <input type="text" id="age" name="age" style="width:330px;" value="' . $age . '" required>
              <br><br>
      
              <label for="phone">Phone:</label><br>
              <input type="text" id="phone" name="phone" style="width:330px;" value="' . $phone . '" required>
              <br><br>
      
              <label for="year">Year of Joining:</label><br>
              <input type="text" id="year" name="year" style="width:330px;" style="width:330px;" value="' . $year . '" required>
              <br><br>
      
              <label for="username">Username:</label><br>
              <input type="text" id="username" name="username" style="width:330px;" value="' . $tusername . '" required>
              <br><br>
      
              <label for="course">Confirm Password:</label><br>
              <input type="password" id="conpassword" name="conpassword" style="width:330px;" style="width:330px;" required>
      <br><br>
      
      </div>
      </div>
      ';
      
      echo'
      <br>
      <input type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" value="Update Teacher">
      </form></div>
      </center>
      ';   
          }}
}
 
  ?>
</div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>