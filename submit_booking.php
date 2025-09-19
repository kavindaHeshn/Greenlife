<?php
// DB connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GreenLife";

$conn = new mysqli($host, $user, $password, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// Form data ganna
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $package = trim($_POST['package']);
    $preferred_date = $_POST['preferred_date'];
    $preferred_time = $_POST['preferred_time'];
    $notes = trim($_POST['notes']);

    // Basic validation
    if (empty($name) || empty($email) || empty($package) || empty($preferred_date) || empty($preferred_time)) {
        echo "<script>alert('Please fill in all required fields.'); window.history.back();</script>";
        exit;
    }

    // SQL insert
    $stmt = $conn->prepare("INSERT INTO bookings (name, email, package_name, preferred_date, preferred_time, notes) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $email, $package, $preferred_date, $preferred_time, $notes);

    if ($stmt->execute()) {
        echo "<script>alert('Your appointment has been booked successfully!'); window.location.href='Services.php';</script>";
    } else {
        echo "<script>alert('Error: Could not save your booking. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
}
$conn->close();
?>
