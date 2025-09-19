<?php
// Start session
session_start();

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GreenLife"; // ✅ Change to your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get and sanitize POST data
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$gender = trim($_POST['gender']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirm-password'];

// Validate passwords match
if ($password !== $confirmPassword) {
    echo "Passwords do not match.";
    exit;
}

// Check if username or email already exists
$check = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$check->bind_param("ss", $username, $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "Username or Email already exists.";
    exit;
}
$check->close();

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user data into database
$insert = $conn->prepare("INSERT INTO users (username, email, phone, gender, password) VALUES (?, ?, ?, ?, ?)");
$insert->bind_param("sssss", $username, $email, $phone, $gender, $hashedPassword);

if ($insert->execute()) {
    // Redirect or show success message
    echo "Registration successful. Redirecting to login...";
    header("refresh:2;url=../viewdashboard/login.php");
} else {
    echo "Registration failed. Please try again.";
}

$insert->close();
$conn->close();
?>
