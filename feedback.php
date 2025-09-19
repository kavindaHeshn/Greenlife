<?php
session_start(); // Start session at the very top

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

$is_admin = $_SESSION['role'] === 'admin';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "greenlife";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('<div class="error">Connection failed: ' . $conn->connect_error . '</div>');
}
$conn->set_charset("utf8mb4");

$success_message = '';
$error_message = '';

// Handle form submission for editing feedback
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_feedback'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];

    $sql = "UPDATE feedback SET name = ?, email = ?, feedback = ?, rating = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $feedback, $rating, $id);

    if ($stmt->execute()) {
        $success_message = "Feedback updated successfully";
    } else {
        $error_message = "Error updating feedback: " . $conn->error;
    }
    $stmt->close();
}

// Handle delete request (only for admins)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_feedback']) && $is_admin) {
    $id = $_POST['id'];
    $sql = "DELETE FROM feedback WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $success_message = "Feedback deleted successfully";
    } else {
        $error_message = "Error deleting feedback: " . $conn->error;
    }
    $stmt->close();
}

// Fetch all feedback entries
$sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GreenLife Staff Dashboard - Manage Feedback</title>
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
      font-family: 'Poppins', Arial, sans-serif;
      margin: 0;
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
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      transition: transform 0.3s ease;
      z-index: 1000;
    }
    .sidebar.hidden {
      transform: translateX(-100%);
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
      padding: 0.75rem 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
      transform: translateX(-20px);
      opacity: 0;
      animation: slideIn 0.5s ease forwards;
      animation-delay: calc(0.1s * var(--index));
      color: #ffca28;
      position: relative;
      text-decoration: none;
      font-size: 1rem;
      font-weight: 700;
    }
    .nav-link:hover {
      background-color: #b74213;
      transform: scale(1.03);
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
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
      padding: 0.75rem 1rem;
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

    /* Menu toggle button */
    .menu-toggle {
      display: none;
      background-color: #4caf50;
      color: #ffffff;
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 0.375rem;
      cursor: pointer;
      position: fixed;
      top: 1rem;
      left: 1rem;
      z-index: 1100;
    }
    .menu-toggle:hover {
      background-color: #2e7d32;
      animation: rotate 0.7s ease-in-out both;
    }
    .menu-toggle:hover span {
      animation: storm 0.7s ease-in-out both;
      animation-delay: 0.06s;
    }

    /* Main content */
    .main-content {
      flex: 1;
      padding: 2rem;
      margin-left: 16rem;
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
      transition: margin-left 0.3s ease;
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

    /* Table styling */
    .feedback-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
      background-color: #ffffff;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      overflow: hidden;
      border: 2px solid #ffca28;
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }
    .feedback-table th, .feedback-table td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #ccc;
      font-weight: 600;
    }
    .feedback-table th {
      background-color: #4caf50;
      color: #ffffff;
      font-weight: 700;
    }
    .feedback-table tr:hover {
      background-color: #e8f4e8;
    }

    /* Action buttons */
    .btn-edit, .btn-delete {
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      border: none;
      cursor: pointer;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      margin-right: 0.5rem;
    }
    .btn-edit {
      background-color: #ffca28;
      color: #333;
    }
    .btn-edit:hover {
      background-color: #b74213;
      color: #ffffff;
      animation: rotate 0.7s ease-in-out both;
    }
    .btn-delete {
      background-color: #dc3545;
      color: #ffffff;
    }
    .btn-delete:hover {
      background-color: #b91c1c;
      animation: rotate 0.7s ease-in-out both;
    }

    /* Form styling */
    .edit-form {
      background-color: #ffffff;
      padding: 1.5rem;
      border-radius: 0.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      border: 2px solid #ffca28;
      margin-top: 2rem;
      display: none;
      animation: fadeIn 0.3s ease forwards;
    }
    .edit-form h3 {
      font-family: 'Algerian', serif;
      color: #b74213;
      margin-bottom: 1rem;
      font-size: 1.5rem;
    }
    .edit-form label {
      display: block;
      margin-bottom: 0.5rem;
      font-weight: 600;
      color: #333;
    }
    .edit-form input, .edit-form textarea, .edit-form select {
      width: 100%;
      padding: 0.5rem;
      margin-bottom: 1rem;
      border: 1px solid #ccc;
      border-radius: 0.375rem;
      background-color: #f9fafb;
      color: #333;
      font-family: 'Poppins', sans-serif;
      font-weight: 600;
    }
    .edit-form button {
      background-color: #4caf50;
      color: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .edit-form button:hover {
      background-color: #2e7d32;
      animation: rotate 0.7s ease-in-out both;
    }

    /* Error and success messages */
    .error, .success {
      text-align: center;
      padding: 1rem;
      border-radius: 0.375rem;
      margin-bottom: 1rem;
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
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .main-content {
        margin-left: 0;
      }
      .menu-toggle {
        display: block;
      }
      .feedback-table th, .feedback-table td {
        padding: 0.75rem;
        font-size: 14px;
      }
    }
    @media (max-width: 480px) {
      .header h2 {
        font-size: 1.8rem;
      }
      .edit-form h3 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <button class="menu-toggle" id="menuToggle" aria-label="Toggle menu"><span>☰ Menu</span></button>
  <div class="flex-container">
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
      <div>
        <div class="logo">
          <img src="../photos/logo.png" alt="GreenLife Wellness Center Logo" aria-label="GreenLife Wellness Center Logo">
        </div>
        <h1 class="text-2xl font-bold mb-6 text-center" style="font-family: 'Algerian', serif;">GreenLife</h1>
        <nav role="navigation" aria-label="Staff navigation">
          <ul>
            <li><a href="contactus.php" class="nav-link" style="--index: 1;" aria-label="Manage inquiries">Manage Inquiries</a></li>
            <li><a href="bookings.php" class="nav-link" style="--index: 2;" aria-label="Manage bookings">Manage Bookings</a></li>
            <li><a href="user.php" class="nav-link" style="--index: 3;" aria-label="Manage users">Manage Users</a></li>
            <li><a href="feedback.php" class="nav-link active" style="--index: 4;" aria-label="Manage feedback">Manage Feedback</a></li>
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
          <h2>Manage Feedback</h2>
          <p>Manage GreenLife operations as <?php echo htmlspecialchars($_SESSION['role'] ?? 'Guest'); ?>.</p>
        </div>
      </div>

      <!-- Success/Error Messages -->
      <?php if ($success_message): ?>
        <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
      <?php endif; ?>
      <?php if ($error_message): ?>
        <div class="error"><?php echo htmlspecialchars($error_message); ?></div>
      <?php endif; ?>

      <!-- Feedback Table -->
      <table class="feedback-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Feedback</th>
            <th>Rating</th>
            <th>Submitted At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['feedback']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?></td>
                <td><?php echo htmlspecialchars($row['submitted_at']); ?></td>
                <td>
                  <button class="btn-edit" onclick="showEditForm(<?php echo $row['id']; ?>, '<?php echo htmlspecialchars(str_replace("'", "\\'", $row['name'])); ?>', '<?php echo htmlspecialchars(str_replace("'", "\\'", $row['email'])); ?>', '<?php echo htmlspecialchars(str_replace("'", "\\'", $row['feedback'])); ?>', <?php echo $row['rating']; ?>)" aria-label="Edit feedback from <?php echo htmlspecialchars($row['name']); ?>"><i class="fas fa-edit"></i></button>
                  <?php if ($is_admin): ?>
                    <form method="POST" action="feedback.php" style="display:inline;">
                      <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                      <button type="submit" name="delete_feedback" class="btn-delete" onclick="return confirm('Are you sure you want to delete this feedback?')" aria-label="Delete feedback from <?php echo htmlspecialchars($row['name']); ?>"><i class="fas fa-trash"></i></button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" style="text-align: center; padding: 1rem;">No feedback found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Edit Feedback Form -->
      <div class="edit-form" id="editForm" role="form" aria-label="Edit feedback form">
        <h3>Edit Feedback</h3>
        <form method="POST" action="feedback.php">
          <input type="hidden" name="id" id="editId">
          <label for="editName">Name:</label>
          <input type="text" name="name" id="editName" required>
          <label for="editEmail">Email:</label>
          <input type="email" name="email" id="editEmail" required>
          <label for="editFeedback">Feedback:</label>
          <textarea name="feedback" id="editFeedback" required></textarea>
          <label for="editRating">Rating (1-5):</label>
          <select name="rating" id="editRating" required>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <button type="submit" name="edit_feedback" aria-label="Update feedback"><span>Update Feedback</span></button>
        </form>
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

    // Show edit form with pre-filled data
    function showEditForm(id, name, email, feedback, rating) {
      document.getElementById('editId').value = id;
      document.getElementById('editName').value = name;
      document.getElementById('editEmail').value = email;
      document.getElementById('editFeedback').value = feedback;
      document.getElementById('editRating').value = rating;
      document.getElementById('editForm').style.display = 'block';
      document.getElementById('editForm').scrollIntoView({ behavior: 'smooth' });
    }

    // Toggle sidebar on mobile
    document.getElementById('menuToggle').addEventListener('click', () => {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('active');
    });
  </script>
</body>
</html>

<?php
$conn->close();
?>