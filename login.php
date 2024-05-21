<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    
    <link href="https://fonts.google.com/specimen/Orelega+One?query=ele">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/brands.min.css" integrity="sha512-W/zrbCncQnky/EzL+/AYwTtosvrM+YG/V6piQLSe2HuKS6cmbw89kjYkp3tWFn1dkWV7L1ruvJyKbLz73Vlgfg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    
   
    <title>Attendance Management System</title>

    <!-- Additional CSS Files -->
    
    <link rel="stylesheet" href="style.css">
   
    <link rel="stylesheet" href="assets\css\loginstyle.css" />


    <style>
        /* CSS RESET */

        body {
	height: 100vh;
		background-size: cover;
		background-color: black;
		background-position: center;
		background-repeat: no-repeat;
		font-family: 'Poppins', sans-serif;
	  
}


        .sub-header {
            margin-top: 1px;
            margin-left: 0%;
            margin-right: 0%;
            margin-bottom: 1%;
            border: 1px solid #000000;
            background-color: lightblue;
        }

        .inputBx select {
        width: 100%;
        padding: 10px;
        font-size: 16px;
        border: none;
        border-bottom: 2px solid #db6e34; /* Add an underline effect */
        background-color: #0000009e;
        color: white;
        border-radius: 0;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        transition: border-bottom 0.3s ease-in-out;
      }
      .custom-border {
            border-bottom: 2px solid black; /* You can adjust the border thickness (4px) to your desired value. */
        }
        .custom-border2 {
            border-top: 2px solid black;
        }
        .left-side-info {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            font-size: 18px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
   
        <header class="header">
            <div class="container padding">
    
                <div class="head">
                    <p>This website is created by <span>Jawad, Abrar, Zaid, Mark and Abdus</span> </p>
                </div>
                <div class="icons">
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-facebook"></i>
                    <i class="fab fa-linkedin"></i>
                    <i class="fab fa-instagram"></i>
                </div>
            </div>
        </header>

        <section class="upper">
            
            <div class="container">
                <div class="content">
                    <div class="nav">
    
                        

      <!-- Move the login form content here -->
    <!-- Logo starts here -->
    <center>
        <br><br>
    <div class="square">
        <i style="--clr: #ff6a00"></i>
        <i style="--clr: #000738"></i>
        <i style="--clr: #ffffff"></i>
        <div class="login">
            <h2>Login</h2>
            <form action="authentication.php" method="POST">
                <br>
            <div class="inputBx">
                <label for="role">Select Role:</label>
                <select id="role" name="role">
                    <option value="admin">Admin</option>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
                <br><br>
            </div>
            <div class="inputBx">
                <input name ="username" id="username" type="text" placeholder="Username" />
            </div>
            <br>
            <div class="inputBx">
                <input id="password" name="password" type="password" placeholder="Password" />
            </div>
  <br>
            <div class="inputBx">
                <input type="submit" value="Sign in" />
            </div>
    </form>

    
            <div class="links">
                <a href="#"></a>
            </div>
        </div>
      </div>
      <center>
</body>

<div class="left-side-info">
    <p>Username: Jawad</p>
    <p>Password: 123</p>
</div>

</html>
