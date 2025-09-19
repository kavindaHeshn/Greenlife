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

    // Handle delete request (admin-only)
    if (isset($_GET['delete_id']) && $is_admin) {
        $delete_id = $_GET['delete_id'];
        $delete_sql = "DELETE FROM doctor_contacts WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $delete_id);
        if ($delete_stmt->execute()) {
            $success_message = "Contact deleted successfully.";
        } else {
            $error_message = "Error deleting contact: " . $conn->error;
        }
        $delete_stmt->close();
    }

    // Handle edit request for full contact (admin-only)
    if (isset($_POST['edit_contact']) && $is_admin) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
        $answer = $_POST['answer'];

        $update_sql = "UPDATE doctor_contacts SET name = ?, email = ?, subject = ?, message = ?, answer = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssssi", $name, $email, $subject, $message, $answer, $id);
        if ($update_stmt->execute()) {
            $success_message = "Contact updated successfully.";
        } else {
            $error_message = "Error updating contact: " . $conn->error;
        }
        $update_stmt->close();
    }

    // Handle answer edit request
    if (isset($_POST['edit_answer'])) {
        $id = $_POST['id'];
        $answer = $_POST['answer'];

        $update_sql = "UPDATE doctor_contacts SET answer = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $answer, $id);
        if ($update_stmt->execute()) {
            $success_message = "Answer updated successfully.";
        } else {
            $error_message = "Error updating answer: " . $conn->error;
        }
        $update_stmt->close();
    }

    // Query to fetch doctor contacts
    $sql = "SELECT id, name, email, subject, message, answer, created_at FROM doctor_contacts ORDER BY created_at DESC";
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
  <title>GreenLife Staff Dashboard - Doctor Contacts</title>
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
      width: 100%;
      max-width: 8rem;
      height: auto;
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
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
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

    /* Action buttons */
    .action-btn {
      padding: 6px 12px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-right: 5px;
    }
    .edit-btn {
      background-color: #ffca28;
      color: #333;
    }
    .edit-btn:hover {
      background-color: #b74213;
      color: #ffffff;
      animation: rotate 0.7s ease-in-out both;
    }
    .delete-btn {
      background-color: #dc3545;
      color: #ffffff;
    }
    .delete-btn:hover {
      background-color: #b91c1c;
      animation: rotate 0.7s ease-in-out both;
    }
    .edit-answer-btn {
      background-color: #4caf50;
      color: #ffffff;
    }
    .edit-answer-btn:hover {
      background-color: #2e7d32;
      animation: rotate 0.7s ease-in-out both;
    }

    /* Modal styling */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal-content {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 500px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      border: 2px solid #ffca28;
      animation: fadeIn 0.3s ease;
    }
    .modal-content h2 {
      font-family: 'Algerian', serif;
      color: #b74213;
      margin-bottom: 20px;
      font-weight: 700;
    }
    .modal-content label {
      display: block;
      margin-bottom: 5px;
      font-weight: 600;
      color: #333;
    }
    .modal-content input, .modal-content select, .modal-content textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-weight: 600;
      font-family: 'Poppins', sans-serif;
    }
    .modal-content button {
      padding: 8px 16px;
      border-radius: 4px;
      border: none;
      cursor: pointer;
      font-weight: 600;
    }
    .modal-content .save-btn {
      background-color: #4caf50;
      color: #ffffff;
      margin-right: 10px;
    }
    .modal-content .save-btn:hover {
      background-color: #2e7d32;
      animation: rotate 0.7s ease-in-out both;
    }
    .modal-content .cancel-btn {
      background-color: #b74213;
      color: #ffffff;
    }
    .modal-content .cancel-btn:hover {
      background-color: #7f2a0d;
      animation: rotate 0.7s ease-in-out both;
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
      .modal-content {
        width: 95%;
      }
    }
    @media screen and (max-width: 480px) {
      .header h2 {
        font-size: 1.8rem;
      }
      .container h1, .modal-content h2 {
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
        <h1 class="text-2xl font-bold mb-6 text-center" style="font-family: 'Algerian', serif;"> GreenLife</h1>
        <nav role="navigation" aria-label="Staff navigation">
          <ul>
            <li><a href="contactus.php" class="nav-link" style="--index: 1;" aria-label="Manage contact us">Manage Contact Us</a></li>
            <li><a href="bookings.php" class="nav-link" style="--index: 2;" aria-label="Manage bookings">Manage Bookings</a></li>
            <li><a href="user.php" class="nav-link" style="--index: 3;" aria-label="Manage users">Manage Users</a></li>
            <li><a href="feedback.php" class="nav-link" style="--index: 4;" aria-label="Manage feedback">Manage Feedback</a></li>
            <li><a href="DoctorContacts.php" class="nav-link active" style="--index: 5;" aria-label="Manage doctor contacts">Manage Doctor Contacts</a></li>
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
          <p>Manage GreenLife operations as <?php echo htmlspecialchars($_SESSION['role'] ?? 'Guest'); ?>.</p>
        </div>
      </div>

      <div class="container">
        <h1>Doctor Contacts List</h1>

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
            echo '<th>Subject</th>';
            echo '<th>Message</th>';
            echo '<th>Answer</th>';
            echo '<th>Created At</th>';
            echo '<th>Actions</th>';
            echo '</tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                echo '<td>' . htmlspecialchars($row['subject']) . '</td>';
                echo '<td>' . htmlspecialchars($row['message']) . '</td>';
                echo '<td>' . htmlspecialchars($row['answer'] ?? '-') . '</td>';
                echo '<td>' . htmlspecialchars($row['created_at']) . '</td>';
                echo '<td>';
                if ($is_admin) {
                    echo '<button class="action-btn edit-btn" onclick="openEditModal(' . htmlspecialchars(json_encode($row)) . ')" aria-label="Edit contact for ' . htmlspecialchars($row['name']) . '"><i class="fas fa-edit"></i></button>';
                    echo '<button class="action-btn delete-btn" onclick="deleteContact(' . htmlspecialchars($row['id']) . ')" aria-label="Delete contact for ' . htmlspecialchars($row['name']) . '"><i class="fas fa-trash"></i></button>';
                }
                echo '<button class="action-btn edit-answer-btn" onclick="openAnswerEditModal(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars(str_replace("'", "\\'", $row['answer'] ?? '')) . '\')" aria-label="Edit answer for ' . htmlspecialchars($row['name']) . '"><i class="fas fa-comment"></i></button>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="no-data">No doctor contacts found.</div>';
        }

        if (isset($stmt)) {
            $stmt->close();
        }
        if (isset($conn)) {
            $conn->close();
        }
        ?>
      </div>

      <!-- Edit Modal -->
      <div id="editModal" class="modal" role="dialog" aria-label="Edit doctor contact">
        <div class="modal-content">
          <h2>Edit Doctor Contact</h2>
          <form id="editForm" method="POST">
            <input type="hidden" name="id" id="editId">
            <label for="editName">Name</label>
            <input type="text" name="name" id="editName" required>
            <label for="editEmail">Email</label>
            <input type="email" name="email" id="editEmail" required>
            <label for="editSubject">Subject</label>
            <input type="text" name="subject" id="editSubject" required>
            <label for="editMessage">Message</label>
            <textarea name="message" id="editMessage" required></textarea>
            <label for="editAnswer">Answer</label>
            <textarea name="answer" id="editAnswer"></textarea>
            <button type="submit" name="edit_contact" class="save-btn" aria-label="Save changes"><span>Save</span></button>
            <button type="button" class="cancel-btn" onclick="closeEditModal()" aria-label="Cancel"><span>Cancel</span></button>
          </form>
        </div>
      </div>

      <!-- Answer Edit Modal -->
      <div id="answerEditModal" class="modal" role="dialog" aria-label="Edit answer">
        <div class="modal-content">
          <h2>Edit Answer</h2>
          <form id="answerEditForm" method="POST">
            <input type="hidden" name="id" id="answerEditId">
            <label for="answerEditInput">Answer</label>
            <textarea name="answer" id="answerEditInput" required></textarea>
            <button type="submit" name="edit_answer" class="save-btn" aria-label="Save answer"><span>Save</span></button>
            <button type="button" class="cancel-btn" onclick="closeAnswerEditModal()" aria-label="Cancel"><span>Cancel</span></button>
          </form>
        </div>
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

    // Edit modal functions
    function openEditModal(contact) {
      document.getElementById('editId').value = contact.id;
      document.getElementById('editName').value = contact.name;
      document.getElementById('editEmail').value = contact.email;
      document.getElementById('editSubject').value = contact.subject;
      document.getElementById('editMessage').value = contact.message;
      document.getElementById('editAnswer').value = contact.answer || '';
      document.getElementById('editModal').style.display = 'flex';
      document.getElementById('editModal').scrollIntoView({ behavior: 'smooth' });
    }

    function closeEditModal() {
      document.getElementById('editModal').style.display = 'none';
    }

    // Answer edit modal functions
    function openAnswerEditModal(id, answer) {
      document.getElementById('answerEditId').value = id;
      document.getElementById('answerEditInput').value = answer || '';
      document.getElementById('answerEditModal').style.display = 'flex';
      document.getElementById('answerEditModal').scrollIntoView({ behavior: 'smooth' });
    }

    function closeAnswerEditModal() {
      document.getElementById('answerEditModal').style.display = 'none';
    }

    // Delete contact function
    function deleteContact(id) {
      if (confirm('Are you sure you want to delete this contact?')) {
        window.location.href = '?delete_id=' + id;
      }
    }
  </script>
</body>
</html>