<?php
$servername = "localhost";
$username = "root"; // your MySQL username
$password = ""; // your MySQL password
$dbname = "mydatabase"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user input
$user = $_POST['username'];
$pass = $_POST['password'];

// Prepare and bind
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$stmt->bind_param("s", $user);

// Execute the query
$stmt->execute();
$stmt->store_result();

// Check if user exists
if ($stmt->num_rows > 0) {
    $stmt->bind_result($hashed_pass);
    $stmt->fetch();

    // Verify password
    if (password_verify($pass, $hashed_pass)) {
        echo "Login successful!";
    } else {
        echo "Invalid username or password.";
    }
} else {
    echo "Invalid username or password.";
}

// Close connection
$stmt->close();
$conn->close();
?>
