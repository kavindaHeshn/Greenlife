<?php
session_start();
include '../configuration/config.php';

// Generate CSRF token if not set
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

// Prefill form fields for logged-in users
$user_name = '';
$user_email = '';
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT username, email FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_name = htmlspecialchars($user['username']);
        $user_email = htmlspecialchars($user['email']);
    }
}

// Handle form submission to answer a message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['answer'], $_POST['msg_id'], $_POST['csrf_token'])) {
    if ($_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die(json_encode(['success' => false, 'message' => 'Invalid CSRF token']));
    }

    $answer = trim($_POST['answer']);
    $msg_id = (int)$_POST['msg_id'];

    if (!empty($answer)) {
        $stmt = $conn->prepare("UPDATE doctor_contacts SET answer = ?, answered_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $answer, $msg_id);
        $stmt->execute();
        $stmt->close();
        // Return JSON response for AJAX
        echo json_encode(['success' => true, 'message' => 'Answer submitted successfully']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Answer cannot be empty']);
        exit;
    }
}

// Fetch messages from doctor_contacts table
$sql = "SELECT id, name, email, subject, message, created_at, answer FROM doctor_contacts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Our Doctors - GreenLife Wellness Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=block" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Algerian';
            src: url('https://fonts.cdnfonts.com/css/algerian') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', Arial, sans-serif;
        }

        :root {
            --green-accent: #4caf50;
            --green-dark: #2e7d32;
            --yellow-accent: #ffca28;
            --brown-accent: #b74213;
            --space-xl: 2rem;
            --space-l: 1.5rem;
            --space-m: 1.25rem;
            --space: 1rem;
            --space-s: 0.5rem;
            --fs-l: 1.4375rem;
            --fs-m: 1.25rem;
            --fs-default: 1rem;
            --fs-s: 0.9rem;
            --anim-time--hi: 266ms;
            --anim-time--med: 400ms;
            --anim-time--lo: 600ms;
        }

        body {
            line-height: 1.6;
            color: #333;
            background-color: #fff;
            scroll-behavior: smooth;
            padding-top: 80px;
        }

        /* Navigation Bar */
        header {
            background-color: #fff;
            color: #333;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            max-width: 100%;
            margin: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 70px;
            border-radius: 8px;
            border: 2px solid var(--yellow-accent);
            background: linear-gradient(45deg, var(--brown-accent), var(--yellow-accent));
            padding: 5px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .logo span {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--brown-accent);
            margin-left: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li a {
            color: var(--yellow-accent);
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: var(--brown-accent);
            transform: translateY(-2px);
        }

        nav ul li a.active {
            color: var(--brown-accent);
            font-weight: 600;
            border-bottom: 2px solid var(--brown-accent);
        }

        /* Intro Section */
        .intro-section {
            text-align: center;
            padding: 80px 20px;
            background: url('../photos/footer-gds-1.png') no-repeat center/cover;
            color: #fff;
            border-bottom: 5px solid var(--green-accent);
        }

        .intro-section h2 {
            font-family: 'Algerian', serif;
            font-size: 3.2rem;
            font-weight: bold;
            color: #181817;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .intro-section p {
            font-size: 1.2rem;
            color: #19a424;
        }

        /* Doctors Contact Section */
        .doctors-contact {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 1200px;
            margin: 0 auto;
        }

        .doctors-contact h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .doctors-contact-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
            display: block;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .doctors-contact-content {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
        }

        .doctors-contact-content p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .doctors-contact-content h3 {
            font-family: 'Algerian', serif;
            font-size: 1.8rem;
            color: var(--brown-accent);
            margin-bottom: 1rem;
        }

        .booking-form {
            margin-top: 2rem;
        }

        .booking-form label {
            display: block;
            font-size: 1rem;
            color: var(--brown-accent);
            margin-bottom: 0.5rem;
        }

        .booking-form input,
        .booking-form textarea {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            transition: border-color 0.3s ease;
        }

        .booking-form input:focus,
        .booking-form textarea:focus {
            border-color: var(--yellow-accent);
            outline: none;
        }

        .booking-form input.invalid,
        .booking-form textarea.invalid {
            border-color: #ff4444;
        }

        .booking-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .booking-form button {
            background-color: var(--green-accent);
            color: #fff;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .booking-form button:hover {
            background-color: var(--green-dark);
            transform: translateY(-2px);
        }

        .success-message {
            color: #4caf50;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1rem;
            display: none;
        }

        .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            margin-top: 0.3rem;
            display: none;
        }

        /* Table Styling */
        .table-container {
            margin-top: 2rem;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }

        .table th,
        .table td {
            padding: 0.8rem;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background-color: var(--brown-accent);
            color: #fff;
            font-weight: 600;
        }

        .table td {
            font-size: 0.9rem;
            color: #333;
        }

        .table .answered {
            color: var(--green-accent);
        }

        .table .no-answer {
            color: #ff4444;
        }

        .answer-form {
            display: flex;
            gap: 0.5rem;
        }

        .answer-form textarea {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .answer-form button {
            padding: 0.5rem 1rem;
            background-color: var(--green-accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .answer-form button:hover {
            background-color: var(--green-dark);
        }

        /* Footer */
        footer {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('../photos/footer.jpg');
            color: #fff;
            padding: 3rem 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 2rem;
        }

        .footer-column {
            flex: 1 1 250px;
        }

        .footer-column h3 {
            font-family: 'Algerian', serif;
            color: var(--yellow-accent);
            font-size: 1.2rem;
            margin-bottom: 1rem;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li a {
            color: #ccc;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-column ul li a:hover {
            color: var(--yellow-accent);
        }

        .footer-contact p {
            font-size: 0.9rem;
            margin-bottom: 0.6rem;
        }

        .footer-contact a {
            color: #ccc;
            text-decoration: none;
        }

        .footer-contact a:hover {
            color: var(--yellow-accent);
        }

        .newsletter form {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .newsletter input[type="email"] {
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            font-size: 0.9rem;
            background-color: #fff;
        }

        .newsletter input[type="email"].invalid {
            border: 2px solid #ff4444;
        }

        .newsletter button {
            background-color: var(--green-accent);
            color: #fff;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter button:hover {
            background-color: var(--green-dark);
        }

        .newsletter .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            display: none;
        }

        .social-icons a {
            color: var(--yellow-accent);
            font-size: 1.5rem;
            margin-right: 10px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-icons a:hover {
            color: #fff;
            transform: scale(1.1);
        }

        .bottom-bar {
            width: 100%;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: #ccc;
        }

        /* Accessibility */
        a:focus, button:focus, input:focus, textarea:focus {
            outline: 2px solid var(--yellow-accent);
            outline-offset: 2px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                gap: 15px;
            }

            nav ul {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .logo img {
                height: 60px;
            }

            .logo span {
                font-size: 1.1rem;
            }

            .intro-section h2 {
                font-size: 2.4rem;
            }

            .doctors-contact h2 {
                font-size: 2rem;
            }

            .doctors-contact-content h3 {
                font-size: 1.6rem;
            }

            .doctors-contact-image {
                max-width: 100%;
            }

            .table {
                display: block;
                overflow-x: auto;
            }

            footer {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .intro-section h2 {
                font-size: 2rem;
            }

            .doctors-contact h2 {
                font-size: 1.8rem;
            }

            .doctors-contact-content h3 {
                font-size: 1.4rem;
            }

            .logo img {
                height: 50px;
            }

            .answer-form {
                flex-direction: column;
            }

            .answer-form textarea {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <header>
        <nav role="navigation" aria-label="Main navigation">
            <div class="logo">
                <img src="../photos/logo.png" alt="GreenLife Wellness Center Logo">
                <span>GreenLife Wellness</span>
            </div>
            <ul>
                <li><a href="customerhome.php">Home</a></li>
      <li><a href="Services.php">Services</a></li>
      <li><a href="doctors.php"class="active">Doctors contact</a></li>
      <li><a href="MedicalHistory.php"> Medical History</a></li>
      <li><a href="feedback.php">feedback</a></li>
      <li><a href="packages.php" >Packages</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Contact Our Doctors</h2>
        <p>Connect with our expert Ayurvedic doctors for personalized consultations and guidance.</p>
    </section>

    <!-- Doctors Contact Section -->
    <section class="doctors-contact" id="doctors-contact" aria-labelledby="doctors-contact-heading">
        <h2 id="doctors-contact-heading">Contact Our Doctors</h2>
        <img src="../photos/Cardiology_Braverman_Male-4617_2880x1440_v1.jpg" alt="Contact Our Ayurvedic Doctors" class="doctors-contact-image">
        <div class="doctors-contact-content">
            <p>At GreenLife Wellness Center, our expert Ayurvedic doctors are here to assist you with personalized consultations and guidance. Whether you have questions about our treatments, need advice on your wellness journey, or want to schedule a consultation, feel free to reach out using the form below.</p>

            <div class="booking-form">
                <div id="success-message" class="success-message" role="alert"></div>
                <div id="error-message" class="error-message" role="alert"></div>
                <form id="contact-form" action="../backend/submit_doctor_contact.php" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo $user_name; ?>" aria-label="Your name" aria-describedby="name-error" required>
                    <div class="error-message" id="name-error">Please enter your name.</div>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $user_email; ?>" aria-label="Your email" aria-describedby="email-error" required>
                    <div class="error-message" id="email-error">Please enter a valid email address.</div>

                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" placeholder="Enter the subject" aria-label="Subject of your message" aria-describedby="subject-error" required>
                    <div class="error-message" id="subject-error">Please enter a subject.</div>

                    <label for="message">Message</label>
                    <textarea id="message" name="message" placeholder="Enter your message" aria-label="Your message" aria-describedby="message-error" required></textarea>
                    <div class="error-message" id="message-error">Please enter your message.</div>

                    <button type="submit" id="submit-button">Submit Message</button>
                </form>
            </div>

            <div class="table-container">
                <h3>Doctor Contact Messages</h3>
                <table class="table" role="grid" aria-label="Doctor contact messages">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Subject</th>
                            <th scope="col">Message</th>
                            <th scope="col">Submitted At</th>
                            <th scope="col">Answer</th>
                            <th scope="col">Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td scope='row'>{$row['id']}</td>
                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                    <td>" . htmlspecialchars($row['subject']) . "</td>
                                    <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                                    <td>{$row['created_at']}</td>";

                            if (!empty($row['answer'])) {
                                echo "<td class='answered'>" . nl2br(htmlspecialchars($row['answer'])) . "</td>
                                      <td class='answered'>✔ Answered</td>";
                            } else {
                                // Restrict answer form to admin users
                                if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                                    echo "<td class='no-answer'>Pending</td>
                                          <td>
                                            <form method='POST' class='answer-form'>
                                                <input type='hidden' name='csrf_token' value='" . htmlspecialchars($_SESSION['csrf_token']) . "'>
                                                <input type='hidden' name='msg_id' value='{$row['id']}'>
                                                <textarea name='answer' rows='2' placeholder='Type answer here...' required aria-label='Answer to message'></textarea>
                                                <button type='submit'>Submit</button>
                                            </form>
                                          </td>";
                                } else {
                                    echo "<td class='no-answer'>Pending</td>
                                          <td>Reply restricted to admins</td>";
                                }
                            }

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' style='text-align:center;'>No messages found</td></tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer role="contentinfo">
        <div class="footer-column">
            <h3>GreenLife Wellness Center</h3>
            <ul>
                <li><a href="customerhome.php">Home</a></li>
                <li><a href="treatments.php">Treatments</a></li>
                <li><a href="Services.php">Services</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Feedback</a></li>
                <li><a href="dashboard.php">Packages</a></li>
            </ul>
        </div>
        <div class="footer-column footer-contact">
            <h3>Get in Touch</h3>
            <p>📍 GreenLife Wellness Center, Colombo, Sri Lanka</p>
            <p>📧 <a href="mailto:GreenLifeWellnessCenter@gmail.com" style="color:#ccc;">GreenLifeWellnessCenter@gmail.com</a></p>
            <p>📞 <a href="tel:+94769889741">+94 76 988 9741</a> (International)</p>
            <p>WhatsApp: <a href="https://wa.me/94769889741">+94 76 988 9741</a></p>
        </div>
        <div class="footer-column newsletter">
            <h3>Stay Connected</h3>
            <form id="newsletter-form">
                <input type="email" id="newsletter-email" placeholder="Enter your email" required aria-label="Email for newsletter subscription">
                <p class="error-message" id="newsletter-email-error">Please enter a valid email address.</p>
                <button type="submit">Subscribe</button>
            </form>
            <div class="social-icons">
                <a href="https://www.facebook.com" aria-label="Visit our Facebook page"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" aria-label="Visit our Instagram page"><i class="fab fa-instagram"></i></a>
                <a href="https://x.com" aria-label="Visit our Twitter page"><i class="fab fa-x-twitter"></i></a>
                <a href="https://www.youtube.com" aria-label="Visit our YouTube channel"><i class="fab fa-youtube"></i></a>
            </div>
        </div>
        <div class="bottom-bar">
            &copy; <?php echo date("Y"); ?> GreenLife Wellness Center. All rights reserved.
        </div>
    </footer>

    <script>
        // Contact Form Validation and AJAX Submission
        document.getElementById('contact-form').addEventListener('submit', async function(event) {
            event.preventDefault();
            
            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.textContent = 'Submitting...';

            // Reset messages
            const successMessage = document.getElementById('success-message');
            const errorMessage = document.getElementById('error-message');
            successMessage.style.display = 'none';
            errorMessage.style.display = 'none';
            document.querySelectorAll('.error-message').forEach(error => error.style.display = 'none');

            // Client-side validation
            let isValid = true;
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!name) {
                document.getElementById('name-error').style.display = 'block';
                document.getElementById('name').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('name').classList.remove('invalid');
            }

            if (!email || !emailRegex.test(email)) {
                document.getElementById('email-error').style.display = 'block';
                document.getElementById('email').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('email').classList.remove('invalid');
            }

            if (!subject) {
                document.getElementById('subject-error').style.display = 'block';
                document.getElementById('subject').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('subject').classList.remove('invalid');
            }

            if (!message) {
                document.getElementById('message-error').style.display = 'block';
                document.getElementById('message').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('message').classList.remove('invalid');
            }

            if (!isValid) {
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Message';
                return;
            }

            const formData = new FormData(this);
            try {
                const response = await fetch('../backend/submit_doctor_contact.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    successMessage.textContent = result.message;
                    successMessage.style.display = 'block';
                    document.getElementById('contact-form').reset();
                    setTimeout(() => location.reload(), 2000); // Refresh to show new message
                } else {
                    errorMessage.textContent = result.message;
                    errorMessage.style.display = 'block';
                }
            } catch (error) {
                errorMessage.textContent = 'An error occurred. Please try again.';
                errorMessage.style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Message';
            }
        });

        // Answer Form Submission
        document.querySelectorAll('.answer-form').forEach(form => {
            form.addEventListener('submit', async function(event) {
                event.preventDefault();
                const submitButton = this.querySelector('button');
                submitButton.disabled = true;
                submitButton.textContent = 'Submitting...';

                const formData = new FormData(this);
                try {
                    const response = await fetch('doctors.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.success) {
                        location.reload(); // Refresh to show updated table
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    alert('An error occurred while submitting the answer.');
                } finally {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Submit';
                }
            });
        });

        // Newsletter Form Validation
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('newsletter-email');
            const emailError = document.getElementById('newsletter-email-error');
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailPattern.test(emailInput.value)) {
                emailInput.classList.add('invalid');
                emailError.style.display = 'block';
            } else {
                emailInput.classList.remove('invalid');
                emailError.style.display = 'none';
                alert('Thank you for subscribing!');
                emailInput.value = '';
            }
        });

        // Smooth Scroll for Navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>