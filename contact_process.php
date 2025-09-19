<?php
header('Content-Type: application/json');

// Database connection configuration
$host = "localhost";
$user = "root"; // Replace with your MySQL username if different
$password = ""; // Replace with your MySQL password if different
$dbname = "GreenLife";

// Create connection
try {
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit();
    }
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection error: ' . $e->getMessage()]);
    exit();
}

// Validate and process form data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';

    // Basic validation
    if (empty($name) || empty($email) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'All fields (Name, Email, Message) are required.']);
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit();
    }

    // Prepare SQL query using prepared statements
    $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'message' => 'Query preparation failed: ' . $conn->error]);
        exit();
    }

    $stmt->bind_param("sss", $name, $email, $message);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Inquiry submitted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error saving inquiry: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

// Close connection
$conn->close();
?>