<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'GreenLife';

try {
    // Create a MySQLi connection
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }
    // Set charset to UTF-8 for proper character encoding
    $conn->set_charset('utf8mb4');

    // Get the JSON data from the request
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Validate input
    if (!isset($data['name']) || empty(trim($data['name']))) {
        echo json_encode(['error' => 'Name is required']);
        http_response_code(400);
        exit;
    }
    if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Valid email is required']);
        http_response_code(400);
        exit;
    }
    if (!isset($data['feedback']) || empty(trim($data['feedback']))) {
        echo json_encode(['error' => 'Feedback is required']);
        http_response_code(400);
        exit;
    }
    if (!isset($data['rating']) || !is_numeric($data['rating']) || $data['rating'] < 1 || $data['rating'] > 5) {
        echo json_encode(['error' => 'Valid rating (1-5) is required']);
        http_response_code(400);
        exit;
    }

    // Prepare and execute the SQL query
    $stmt = $conn->prepare('INSERT INTO feedback (name, email, feedback, rating) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('sssi', $data['name'], $data['email'], $data['feedback'], $data['rating']);
    $stmt->execute();

    // Success response
    echo json_encode(['message' => 'Feedback submitted successfully']);
    http_response_code(200);

    // Close statement and connection
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    // General error
    echo json_encode(['error' => 'An error occurred: ' . $e->getMessage()]);
    http_response_code(500);
}
?>