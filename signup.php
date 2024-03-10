<?php
// Database connection parameters
$servername = "localhost";
 
$username = "root"; // The default username for a local MySQL server

$dbname = "SignUp"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to store user input and error messages
$fname = $lname = $email = $password = $confirmPassword = "";
$errors = [];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize user input
    $fname = sanitizeInput($_POST["fname"]);
    $lname = sanitizeInput($_POST["lname"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $confirmPassword = sanitizeInput($_POST["confirm-password"]);

    // Perform form validation
    if (empty($fname)) {
        $errors[] = "First Name is required.";
    }

    if (empty($lname)) {
        $errors[] = "Last Name is required.";
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($password)) {
        $errors[] = "Password is required.";
    }

    if (empty($confirmPassword)) {
        $errors[] = "Confirm Password is required.";
    } elseif ($password !== $confirmPassword) {
        $errors[] = "Password and Confirm Password do not match.";
    }

    // If no errors, proceed with database insertion
    if (empty($errors)) {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user data into the database
        $sql = "INSERT INTO Users (FirstName, LastName, Email, Password) VALUES ('$fname', '$lname', '$email', '$hashedPassword')";

        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        // Display error messages
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
}

// Close the database connection
$conn->close();

// Function to sanitize user input
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
