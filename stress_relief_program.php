<?php
session_start();
include '../configuration/config.php';

// Generate CSRF token if not set (assuming config.php handles this)
if (empty($_SESSION['csrf_token'])) {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ayurvedic Stress Relief Program - GreenLife Wellness Center</title>
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

        /* Stress Relief Program Section */
        .stress-relief {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stress-relief h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .stress-relief-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            border-radius: 10px;
            display: block;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .stress-relief-content {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
        }

        .stress-relief-content p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .stress-relief-content h3 {
            font-family: 'Algerian', serif;
            font-size: 1.8rem;
            color: var(--brown-accent);
            margin-bottom: 1rem;
        }

        .stress-relief-content ul {
            list-style: disc;
            padding-left: 20px;
            margin-bottom: 1.5rem;
        }

        .stress-relief-content ul li {
            font-size: 1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .stress-relief-content ul li strong {
            color: var(--brown-accent);
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
        .booking-form select,
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
        .booking-form select:focus,
        .booking-form textarea:focus {
            border-color: var(--yellow-accent);
            outline: none;
        }

        .booking-form input.invalid,
        .booking-form select.invalid,
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
        a:focus, button:focus, input:focus, select:focus, textarea:focus {
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

            .stress-relief h2 {
                font-size: 2rem;
            }

            .stress-relief-content h3 {
                font-size: 1.6rem;
            }

            .stress-relief-image {
                max-width: 100%;
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

            .stress-relief h2 {
                font-size: 1.8rem;
            }

            .stress-relief-content h3 {
                font-size: 1.4rem;
            }

            .logo img {
                height: 50px;
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
      <li><a href="doctors.php">Doctors contact</a></li>
      <li><a href="MedicalHistory.php"> Medical History</a></li>
      <li><a href="feedback.php">feedback</a></li>
      <li><a href="packages.php" >Packages</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Ayurvedic Stress Relief Program</h2>
        <p>Unwind and restore balance with our holistic stress relief therapies.</p>
    </section>

    <!-- Stress Relief Program Section -->
    <section class="stress-relief" id="stress-relief" aria-labelledby="stress-relief-heading">
        <h2 id="stress-relief-heading">Ayurvedic Stress Relief Program</h2>
        <img src="../photos/opti-50_1-1-Head-Massage-2.avif" alt="Ayurvedic Stress Relief Program" class="stress-relief-image">
        <div class="stress-relief-content">
            <p>At GreenLife Wellness Center, our Ayurvedic Stress Relief Program is crafted to help you unwind, reduce anxiety, and restore balance using holistic Ayurvedic practices. This program combines therapeutic treatments and mindfulness techniques to promote deep relaxation and mental well-being.</p>
            
            <h3>Program Highlights</h3>
            <ul>
                <li><strong>Abhyanga (Oil Massage)</strong>: Full-body warm herbal oil massage to relieve tension and improve circulation.</li>
                <li><strong>Shirodhara</strong>: Gentle pouring of warm herbal oil on the forehead to calm the nervous system and reduce stress.</li>
                <li><strong>Yoga & Meditation</strong>: Guided sessions combining yoga asanas and meditation to promote mental clarity and emotional stability.</li>
                <li><strong>Herbal Remedies</strong>: Utilizes herbs like Ashwagandha and Brahmi to support stress relief and mental resilience.</li>
                <li><strong>Counselling</strong>: Personalized sessions to address emotional and mental well-being.</li>
            </ul>

            <h3>Benefits</h3>
            <ul>
                <li>Reduces stress and anxiety for a calmer mind.</li>
                <li>Improves sleep quality and relaxation.</li>
                <li>Enhances mental clarity and focus.</li>
                <li>Promotes emotional balance and resilience.</li>
                <li>Supports overall physical and mental well-being.</li>
            </ul>

            <div class="booking-form">
                <div class="success-message" id="success-message" role="alert"></div>
                <form id="booking-form" action="../backend/submit_booking.php" method="POST" onsubmit="return validateBooking(event)">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo $user_name; ?>" aria-label="Your full name" aria-describedby="name-error" required>
                    <div class="error-message" id="name-error">Please enter your name.</div>

                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo $user_email; ?>" aria-label="Your email address" aria-describedby="email-error" required>
                    <div class="error-message" id="email-error">Please enter a valid email address.</div>

                    <label for="treatment">Treatments</label>
                    <select id="treatment" name="treatment" aria-label="Select a treatment package" aria-describedby="treatment-error" required>
                        <option value="" disabled selected>Select a treatment</option>
                        <option value="Abhyanga (Oil Massage)">Abhyanga (Oil Massage)</option>
                        <option value="Shirodhara">Shirodhara</option>
                        <option value="Yoga & Meditation">Yoga & Meditation</option>
                        <option value="Herbal Remedies">Herbal Remedies</option>
                        <option value="Counselling">Counselling</option>
                    </select>
                    <div class="error-message" id="treatment-error">Please select a treatment.</div>

                    <label for="preferred-date">Preferred Date</label>
                    <input type="date" id="preferred-date" name="preferred_date" aria-label="Preferred appointment date" aria-describedby="date-error" required>
                    <div class="error-message" id="date-error">Please select a date (today or future).</div>

                    <label for="preferred-time">Preferred Time</label>
                    <input type="time" id="preferred-time" name="preferred_time" aria-label="Preferred appointment time" aria-describedby="time-error" required>
                    <div class="error-message" id="time-error">Please select a time.</div>

                    <label for="notes">Additional Notes</label>
                    <textarea id="notes" name="notes" placeholder="Any additional information" aria-label="Additional notes for your booking"></textarea>

                    <button type="submit">Book Appointment</button>
                </form>
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
        // Booking Form Validation and AJAX Submission
        function validateBooking(event) {
            event.preventDefault();
            let isValid = true;

            // Reset error and success messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            document.getElementById('success-message').style.display = 'none';

            // Validate name
            const name = document.getElementById('name').value.trim();
            if (!name) {
                document.getElementById('name-error').style.display = 'block';
                document.getElementById('name').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('name').classList.remove('invalid');
            }

            // Validate email
            const email = document.getElementById('email').value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email || !emailRegex.test(email)) {
                document.getElementById('email-error').style.display = 'block';
                document.getElementById('email').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('email').classList.remove('invalid');
            }

            // Validate treatment
            const treatment = document.getElementById('treatment').value;
            if (!treatment) {
                document.getElementById('treatment-error').style.display = 'block';
                document.getElementById('treatment').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('treatment').classList.remove('invalid');
            }

            // Validate date
            const date = document.getElementById('preferred-date').value;
            const today = new Date().toISOString().split('T')[0];
            if (!date || date < today) {
                document.getElementById('date-error').style.display = 'block';
                document.getElementById('preferred-date').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('preferred-date').classList.remove('invalid');
            }

            // Validate time
            const time = document.getElementById('preferred-time').value;
            if (!time) {
                document.getElementById('time-error').style.display = 'block';
                document.getElementById('preferred-time').classList.add('invalid');
                isValid = false;
            } else {
                document.getElementById('preferred-time').classList.remove('invalid');
            }

            // Submit form via AJAX if valid
            if (isValid) {
                const form = document.getElementById('booking-form');
                const formData = new FormData(form);
                fetch(form.action, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('success-message').textContent = data.message;
                    document.getElementById('success-message').style.color = data.success ? '#4caf50' : '#ff4444';
                    document.getElementById('success-message').style.display = 'block';
                    if (data.success) {
                        form.reset();
                    }
                })
                .catch(error => {
                    document.getElementById('success-message').textContent = 'Error submitting form. Please try again.';
                    document.getElementById('success-message').style.color = '#ff4444';
                    document.getElementById('success-message').style.display = 'block';
                });
            }
        }

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