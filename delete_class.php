<html>
    <head>
<script>
            // Display an alert and redirect to admin_classes.php
            function showAlertAndRedirect() {
                alert("Class deleted successfully!");
                window.location.href = "admin_classes.php";
            }
        </script>
    </head>
    <body>
        <?php
            session_start();
            if (isset($_SESSION["username"]) && $_SESSION["role"]) {
                if (isset($_GET['Subject_ID'])) {
                    // Retrieve the values
                    $Subject_ID = $_GET['Subject_ID'];
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

                    // Drop the table and delete the subject
                    $sql = "DROP TABLE $Subject_ID";
                    $result = $conn->query($sql);

                    $sql = "DELETE FROM subjects WHERE Subject_ID='$Subject_ID'";
                    $result = $conn->query($sql);

                    // Close the database connection
                    $conn->close();

                    // Display the JavaScript code for the alert and redirection
                    echo '<script>showAlertAndRedirect();</script>';
                }
            }
        ?>
</body></html>