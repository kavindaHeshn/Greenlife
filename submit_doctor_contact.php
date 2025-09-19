<?php
session_start();
header('Content-Type: application/json');

// CSRF validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
    exit;
}

// Regenerate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Database connection
include '../configuration/config.php';

// Prepare data
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Server-side validation
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['success' => false, 'message' => 'All fields are required.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
    exit;
}

try {
    $stmt = $conn->prepare("INSERT INTO doctor_contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    $stmt->execute();
    $stmt->close();
    
    echo json_encode(['success' => true, 'message' => 'Message submitted successfully.']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>