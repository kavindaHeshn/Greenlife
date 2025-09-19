<?php
session_start(); // Start session at the very top

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$is_admin = $_SESSION['role'] === 'admin';

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "GreenLife";

try {
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        die('<div class="error">Connection failed: ' . $conn->connect_error . '</div>');
    }
    $conn->set_charset("utf8mb4");

    $success_message = '';
    $error_message = '';

    // Query to fetch inquiries
    $sql = "SELECT id, name, email, message, created_at FROM inquiries ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
} catch (Exception $e) {
    $error_message = "Database connection error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GreenLife Staff Dashboard - Inquiries</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=block" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    @font-face {
      font-family: 'Algerian';
      src: url('https://fonts.cdnfonts.com/css/algerian') format('truetype');
      font-weight: normal;
      font-style: normal;
    }

    /* Body styling */
    body {
      background-color: #e8f5e9;
      color: #333;
      margin: 0;
      font-family: 'Poppins', Arial, sans-serif;
      font-weight: 600;
      scroll-behavior: smooth;
    }

    /* Sidebar */
    .sidebar {
      width: 16rem;
      background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7));
      color: #ffca28;
      padding: 1rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      min-height: 100vh;
    }

    /* Logo styling */
    .logo {
      display: flex;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    .logo img {
      max-width: 8rem;
      border-radius: 0.5rem;
      border: 2px solid #ffca28;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }

    /* Sidebar links */
    .nav-link {
      display: block;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, transform 0.3s ease;
      transform: translateX(-20px);
      opacity: 0;
      animation: slideIn 0.5s ease forwards;
      animation-delay: calc(0.1s * var(--index));
      color: #ffca28;
      position: relative;
      text-decoration: none;
      font-weight: 700;
    }
    .nav-link:hover {
      background-color: #b74213;
      transform: scale(1.03);
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 1rem;
      background-color: #4caf50;
      transition: width 0.3s ease;
    }
    .nav-link:hover::after {
      width: calc(100% - 2rem);
    }
    .nav-link.active {
      background-color: #4caf50;
      font-weight: 800;
    }

    /* Logout button */
    .btn-logout {
      width: 100%;
      background-color: #4caf50;
      color: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-weight: 700;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border: none;
      cursor: pointer;
    }
    .btn-logout:hover {
      background-color: #2e7d32;
      animation: rotate 0.7s ease-in-out both;
    }
    .btn-logout:hover span {
      animation: storm 0.7s ease-in-out both;
      animation-delay: 0.06s;
    }

    /* Main content */
    .main-content {
      flex: 1;
      padding: 2rem;
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .header h2 {
      font-family: 'Algerian', serif;
      font-size: 1.875rem;
      font-weight: 800;
      color: #b74213;
    }
    .header p {
      color: #333;
      font-weight: 600;
    }

    /* Flex container for layout */
    .flex-container {
      display: flex;
      min-height: 100vh;
    }

    /* Container styling */
    .container {
      max-width: 1200px;
      margin: 0 auto;
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border: 2px solid #ffca28;
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }
    .container h1 {
      font-family: 'Algerian', serif;
      font-size: 2.5rem;
      color: #b74213;
      text-align: center;
      margin-bottom: 1.5rem;
    }

    /* Table styling */
    .table-container {
      overflow-x: auto;
      margin-top: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    th, td {
      padding: 12px;
      text-align: left;
      border-bottom: 1px solid #ccc;
      font-weight: 600;
    }
    th {
      background-color: #4caf50;
      color: white;
      font-weight: 700;
    }
    tr:nth-child(even) {
      background-color: #f8f9fa;
    }
    tr:hover {
      background-color: #e8f4e8;
    }

    /* No data styling */
    .no-data {
      text-align: center;
      color: #333;
      padding: 20px;
      font-weight: 600;
    }

    /* Error and success messages */
    .error, .success {
      text-align: center;
      padding: 15px;
      border-radius: 4px;
      margin-bottom: 20px;
      font-weight: 600;
    }
    .error {
      color: #dc3545;
      background-color: #f8d7da;
    }
    .success {
      color: #15803d;
      background-color: #e8f4e8;
    }

    /* Send mail button */
    .send-mail-btn {
      background-color: #ffca28;
      color: #333;
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .send-mail-btn:hover {
      background-color: #b74213;
      color: #ffffff;
      animation: rotate 0.7s ease-in-out both;
    }
    .send-mail-btn:hover span {
      animation: storm 0.7s ease-in-out both;
      animation-delay: 0.06s;
    }

    /* Animations */
    @keyframes slideIn {
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }
    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
    @keyframes rotate {
      0% { transform: rotate(0deg) translate3d(0, 0, 0); }
      25% { transform: rotate(3deg) translate3d(0, 0, 0); }
      50% { transform: rotate(-3deg) translate3d(0, 0, 0); }
      75% { transform: rotate(1deg) translate3d(0, 0, 0); }
      100% { transform: rotate(0deg) translate3d(0, 0, 0); }
    }
    @keyframes storm {
      0% { transform: translate3d(0, 0, 0) translateZ(0); }
      25% { transform: translate3d(4px, 0, 0) translateZ(0); }
      50% { transform: translate3d(-3px, 0, 0) translateZ(0); }
      75% { transform: translate3d(2px, 0, 0) translateZ(0); }
      100% { transform: translate3d(0, 0, 0) translateZ(0); }
    }

    /* Accessibility */
    a:focus, button:focus {
      outline: 2px solid #ffca28;
      outline-offset: 2px;
    }

    /* Responsive design */
    @media screen and (max-width: 768px) {
      .flex-container {
        flex-direction: column;
      }
      .sidebar {
        width: 100%;
        min-height: auto;
      }
      th, td {
        padding: 8px;
        font-size: 14px;
      }
    }
    @media screen and (max-width: 480px) {
      .header h2 {
        font-size: 1.8rem;
      }
      .container h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="flex-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <div class="logo">
          <img src="../photos/logo.png" alt="GreenLife Wellness Center Logo" aria-label="GreenLife Wellness Center Logo">
        </div>
        <h1 class="text-2xl font-bold mb-6 text-center" style="font-family: 'Algerian', serif;">GreenLife</h1>
        <nav role="navigation" aria-label="Staff navigation">
          <ul>
            <li><a href="contactus.php" class="nav-link active" style="--index: 1;" aria-label="Manage contact us">Manage Contact Us</a></li>
            <li><a href="bookings.php" class="nav-link" style="--index: 2;" aria-label="Manage bookings">Manage Bookings</a></li>
            <li><a href="user.php" class="nav-link" style="--index: 3;" aria-label="Manage users">Manage Users</a></li>
            <li><a href="feedback.php" class="nav-link" style="--index: 4;" aria-label="Manage feedback">Manage Feedback</a></li>
            <li><a href="DoctorContacts.php" class="nav-link" style="--index: 5;" aria-label="Manage doctor contacts">Manage Doctor Contacts</a></li>
            <li><a href="medical_histories.php" class="nav-link" style="--index: 6;" aria-label="Manage medical histories">Manage Medical Histories</a></li>
          </ul>
        </nav>
      </div>
      <div class="mt-6">
        <button id="logoutBtn" class="btn-logout" aria-label="Logout"><span>Logout</span></button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <div class="header">
        <div>
          <h2>Staff Dashboard</h2>
          <p>Manage inquiries as <?php echo htmlspecialchars($_SESSION['role'] ?? 'Guest'); ?>.</p>
        </div>
      </div>

      <div class="container">
        <h1>Inquiries List</h1>

        <!-- Success/Error Messages -->
        <?php if (isset($success_message) && $success_message): ?>
          <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if (isset($error_message) && $error_message): ?>
          <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php
        if (isset($result) && $result->num_rows > 0) {
            echo '<div class="table-container">';
            echo '<table>';
            echo '<tr>';
            echo '<th>ID</th>';
            echo '<th>Name</th>';
            echo '<th>Email</th>';
            echo '<th>Message</th>';
            echo '<th>Created At</th>';
            echo '<th>Action</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message'] ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                echo '<td>';
                echo '<button class="send-mail-btn" data-email="' . htmlspecialchars($row['email']) . '" data-name="' . htmlspecialchars($row['name']) . '" aria-label="Send response mail to ' . htmlspecialchars($row['name']) . '"><span><i class="fas fa-envelope"></i></span></button>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="no-data">No inquiries found.</div>';
        }

        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
        ?>
      </div>
    </div>
  </div>

  <script>
    // Logout confirmation
    document.getElementById('logoutBtn').addEventListener('click', () => {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'login.php';
      }
    });

    // Active link highlighting
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
      });
    });

    // Send mail functionality
    document.querySelectorAll('.send-mail-btn').forEach(button => {
      button.addEventListener('click', () => {
        const email = button.getAttribute('data-email');
        const name = button.getAttribute('data-name');

        if (confirm(`Send response mail to ${name}?`)) {
          fetch('send_mail.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `email=${encodeURIComponent(email)}&name=${encodeURIComponent(name)}`
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              const successDiv = document.createElement('div');
              successDiv.className = 'success';
              successDiv.textContent = data.message;
              document.querySelector('.container').prepend(successDiv);
              setTimeout(() => successDiv.remove(), 5000);
            } else {
              const errorDiv = document.createElement('div');
              errorDiv.className = 'error';
              errorDiv.textContent = data.message;
              document.querySelector('.container').prepend(errorDiv);
              setTimeout(() => errorDiv.remove(), 5000);
            }
          })
          .catch(error => {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error';
            errorDiv.textContent = 'Error sending mail: ' + error;
            document.querySelector('.container').prepend(errorDiv);
            setTimeout(() => errorDiv.remove(), 5000);
          });
        }
      });
    });
  </script>
</body>
</html>