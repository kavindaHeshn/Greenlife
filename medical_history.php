<?php
session_start();
header('Content-Type: application/json');

// CSRF validation
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    echo json_encode(['success' => false, 'message' => 'Invalid CSRF token.']);
    exit;
}

// Regenerate CSRF token after submission
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Database connection (update with your credentials)
$host = 'localhost';
$dbname = 'GreenLife';  // Replace with your database name
$username = 'root';  // Replace with your DB username
$password = '';  // Replace with your DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

// Prepare data
$name = $_POST['name'] ?? '';
$dob = $_POST['dob'] ?? '';
$gender = $_POST['gender'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$emergency_contact_name = $_POST['emergency_contact_name'] ?? '';
$emergency_contact_relationship = $_POST['emergency_contact_relationship'] ?? '';
$emergency_contact_phone = $_POST['emergency_contact_phone'] ?? '';
$insurance_provider = $_POST['insurance_provider'] ?? '';
$policy_number = $_POST['policy_number'] ?? '';
$personal_history = isset($_POST['personal_history']) ? implode(', ', $_POST['personal_history']) : '';
$other_medical_issues = $_POST['other_medical_issues'] ?? '';
$treatments_medications = $_POST['treatments_medications'] ?? '';
$surgeries_procedures = $_POST['surgeries_procedures'] ?? '';
$allergies = $_POST['allergies'] ?? '';
$family_history = isset($_POST['family_history']) ? implode(', ', $_POST['family_history']) : '';
$family_history_other = $_POST['family_history_other'] ?? '';

// Server-side validation (basic)
if (empty($name) || empty($dob) || empty($gender) || empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Required fields are missing.']);
    exit;
}

// Insert into database
try {
    $stmt = $pdo->prepare("
        INSERT INTO medical_histories (
            name, dob, gender, address, phone, 
            emergency_contact_name, emergency_contact_relationship, emergency_contact_phone, 
            insurance_provider, policy_number, 
            personal_history, other_medical_issues, 
            treatments_medications, surgeries_procedures, allergies, 
            family_history, family_history_other, created_at
        ) VALUES (
            :name, :dob, :gender, :address, :phone, 
            :emergency_contact_name, :emergency_contact_relationship, :emergency_contact_phone, 
            :insurance_provider, :policy_number, 
            :personal_history, :other_medical_issues, 
            :treatments_medications, :surgeries_procedures, :allergies, 
            :family_history, :family_history_other, NOW()
        )
    ");

    $stmt->execute([
        ':name' => $name,
        ':dob' => $dob,
        ':gender' => $gender,
        ':address' => $address,
        ':phone' => $phone,
        ':emergency_contact_name' => $emergency_contact_name,
        ':emergency_contact_relationship' => $emergency_contact_relationship,
        ':emergency_contact_phone' => $emergency_contact_phone,
        ':insurance_provider' => $insurance_provider,
        ':policy_number' => $policy_number,
        ':personal_history' => $personal_history,
        ':other_medical_issues' => $other_medical_issues,
        ':treatments_medications' => $treatments_medications,
        ':surgeries_procedures' => $surgeries_procedures,
        ':allergies' => $allergies,
        ':family_history' => $family_history,
        ':family_history_other' => $family_history_other
    ]);

    echo json_encode(['success' => true, 'message' => 'Medical history submitted successfully.']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}