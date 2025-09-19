<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GreenLife";

try {
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Set charset to UTF-8 for proper character encoding
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    // Redirect with error message
    header("Location: ../contact.html?status=error&error_message=" . urlencode("Database connection error: " . $e->getMessage()));
    exit();
}

// Function to sanitize input data
function sanitizeInput($data, $conn) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $name = isset($_POST['name']) ? sanitizeInput($_POST['name'], $conn) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email'], $conn) : '';
    $message = isset($_POST['message']) ? sanitizeInput($_POST['message'], $conn) : '';

    // Server-side validation
    $errors = [];
    if (empty($name)) {
        $errors[] = "Name is required.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email is required.";
    }
    if (empty($message)) {
        $errors[] = "Message is required.";
    }

    if (!empty($errors)) {
        // Redirect back with error message
        $errorMessage = implode(" ", $errors);
        header("Location: ../contact.html?status=error&error_message=" . urlencode($errorMessage));
        exit();
    }

    // Prepare and execute SQL query
    try {
        $stmt = $conn->prepare("INSERT INTO inquiries (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: ../contact.html?status=success");
        } else {
            // Redirect with error message
            header("Location: ../contact.html?status=error&error_message=" . urlencode("Failed to save inquiry."));
        }

        $stmt->close();
    } catch (Exception $e) {
        // Redirect with error message
        header("Location: ../contact.html?status=error&error_message=" . urlencode("Error saving inquiry: " . $e->getMessage()));
    }
} else {
    // Redirect if accessed directly without POST
    header("Location: ../contact.html?status=error&error_message=" . urlencode("Invalid request method."));
}

// Close database connection
$conn->close();
?>