<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Your database connection parameters
   $servername = "localhost";
 
    $username = "root"; // The default username for a local MySQL server
    
    $dbname = "SignUp"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perform SQL query to check if the email and password match
    $sql = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Successful login
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        // Incorrect email or password
        echo json_encode(["success" => false, "message" => "Incorrect email or password"]);
    }

    $conn->close();
}
?>
