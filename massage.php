<?php
session_start();
include '../configuration/config.php';

// Generate CSRF token for booking form
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Massage Therapy - GreenLife Wellness Center</title>
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

        /* Massage Therapy Section */
        .massage-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 1200px;
            margin: 0 auto;
        }

        .massage-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .massage-image img {
            width: 100%;
            height: 800px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            border: 2px solid var(--yellow-accent);
        }

        .massage-section p {
            font-size: 1rem;
            color: #333;
            text-align: center;
            margin-bottom: 2rem;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .massage-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            justify-items: center;
            margin-bottom: 2rem;
        }

        .content-card {
            background: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
            text-align: center;
            transition: transform 0.3s ease;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .content-card img {
            width: 100%;
            height: 800px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .content-card h3 {
            font-family: 'Algerian', serif;
            font-size: 1.5rem;
            color: var(--brown-accent);
            margin-bottom: 0.5rem;
        }

        .content-card p {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .content-card ul {
            list-style: none;
            text-align: left;
            margin: 1rem 0;
        }

        .content-card ul li {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 0.5rem;
            position: relative;
            padding-left: 1.5rem;
        }

        .content-card ul li:before {
            content: '✔';
            color: var(--green-accent);
            position: absolute;
            left: 0;
        }

        .content-card a {
            color: var(--green-accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .content-card a:hover {
            color: var(--brown-accent);
        }

        /* Booking Form */
        .booking-form {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
        }

        .booking-form h2 {
            font-family: 'Algerian', serif;
            font-size: 2rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 1rem;
            color: var(--brown-accent);
            margin-bottom: 0.5rem;
        }

        .form-group label i {
            margin-right: 0.5rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--yellow-accent);
            outline: none;
        }

        .form-group input.invalid,
        .form-group select.invalid,
        .form-group textarea.invalid {
            border-color: #ff4444;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        #package-price {
            font-size: 1.2rem;
            color: var(--green-accent);
            text-align: center;
            margin-bottom: 1rem;
            display: none;
        }

        .error-message,
        .success-message,
        .server-error {
            text-align: center;
            margin-top: 1rem;
            font-size: 1rem;
            display: none;
        }

        .error-message {
            color: #ff4444;
        }

        .success-message {
            color: var(--green-accent);
        }

        .server-error {
            color: #ff4444;
        }

        /* Animated Button Styling */
        .booking-form button {
            position: relative;
            outline: none;
            text-decoration: none;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            text-transform: uppercase;
            height: 60px;
            width: 210px;
            opacity: 1;
            background-color: var(--green-accent);
            border: 1px solid var(--green-dark);
            margin: 1rem auto;
            transition: all 0.3s ease;
        }

        .booking-form button span {
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.7px;
        }

        .booking-form button:hover {
            animation: rotate 0.7s ease-in-out both;
        }

        .booking-form button:hover span {
            animation: storm 0.7s ease-in-out both;
            animation-delay: 0.06s;
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

            .massage-section h2,
            .booking-form h2 {
                font-size: 2rem;
            }

            .massage-image img {
                height: 240px;
            }

            .content-card {
                width: 100%;
            }

            .content-card img {
                height: 400px;
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

            .massage-section h2,
            .booking-form h2 {
                font-size: 1.8rem;
            }

            .logo img {
                height: 50px;
            }

            .booking-form button {
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
      <li><a href="doctors.php">Doctors contact</a></li>
      <li><a href="MedicalHistory.php"> Medical History</a></li>
      <li><a href="feedback.php">feedback</a></li>
      <li><a href="packages.php" >Packages</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Massage Therapy</h2>
        <p>Relax and rejuvenate with therapeutic massages to relieve tension and promote overall well-being.</p>
    </section>

    <!-- Massage Therapy Section -->
    <section class="massage-section" id="massage-section" aria-labelledby="massage-heading">
        <h2 id="massage-heading"><i class="fas fa-spa"></i> Massage Therapy</h2>
        <div class="massage-image">
            <img src="../photos/abhayanka_male.jpg" alt="Massage Therapy at GreenLife Wellness Center" loading="lazy">
        </div>
        <p>Relax and rejuvenate with our therapeutic massage sessions designed to relieve tension, reduce stress, and promote overall well-being. Our skilled therapists offer a variety of massage techniques tailored to your specific needs, ensuring a calming and restorative experience.</p>

        <div class="massage-content">
            <div class="content-card">
                <img src="../photos/Massage-Therapy-1208x740-v1.jpg" alt="Swedish Massage" loading="lazy">
                <h3>Swedish Massage</h3>
                <p>A gentle, relaxing massage using long strokes and kneading to promote relaxation and improve circulation.</p>
                <ul>
                    <li>Stress Relief</li>
                    <li>Improved Circulation</li>
                    <li>Muscle Relaxation</li>
                </ul>
                <a href="#booking-form">Learn More</a>
            </div>
            <div class="content-card">
                <img src="../photos/swedish-massage-pexels-jonathan-borba-19641830-copy.jpg" alt="Deep Tissue Massage" loading="lazy">
                <h3>Deep Tissue Massage</h3>
                <p>A focused massage targeting deeper layers of muscle to relieve chronic pain and tension.</p>
                <ul>
                    <li>Chronic Pain Relief</li>
                    <li>Muscle Tension Reduction</li>
                    <li>Improved Mobility</li>
                </ul>
                <a href="#booking-form">Learn More</a>
            </div>
        </div>

        <div class="booking-form">
            <h2><i class="fas fa-calendar-check"></i> Book Your Massage Session</h2>
            <div class="form-container">
                <div id="booking-success-message" class="success-message" role="alert"></div>
                <div id="booking-server-error" class="server-error" role="alert"></div>
                <form id="booking-form" method="POST">
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                    <div class="form-group">
                        <label for="booking-name"><i class="fas fa-user"></i> Name</label>
                        <input type="text" id="booking-name" name="name" placeholder="Enter your name" value="<?php echo $user_name; ?>" aria-label="Your name" required>
                        <div class="error-message" id="booking-name-error">Please enter your name.</div>
                    </div>
                    <div class="form-group">
                        <label for="booking-email"><i class="fas fa-envelope"></i> Email</label>
                        <input type="email" id="booking-email" name="email" placeholder="Enter your email" value="<?php echo $user_email; ?>" aria-label="Your email" required>
                        <div class="error-message" id="booking-email-error">Please enter a valid email address.</div>
                    </div>
                    <div class="form-group">
                        <label for="booking-package"><i class="fas fa-box"></i> Massage Package</label>
                        <select id="booking-package" name="package" aria-label="Select a massage package" required onchange="updatePrice()">
                            <option value="" disabled selected>Select a package</option>
                            <option value="Swedish Massage">Swedish Massage</option>
                            <option value="Deep Tissue Massage">Deep Tissue Massage</option>
                            <option value="Aromatherapy Massage">Aromatherapy Massage</option>
                        </select>
                        <div class="error-message" id="booking-package-error">Please select a package.</div>
                    </div>
                    <div id="package-price">Price: LKR 0</div>
                    <div class="form-group">
                        <label for="preferred-date"><i class="fas fa-calendar"></i> Preferred Date</label>
                        <input type="date" id="preferred-date" name="preferred_date" aria-label="Preferred appointment date" required>
                        <div class="error-message" id="date-error">Please select a date.</div>
                    </div>
                    <div class="form-group">
                        <label for="preferred-time"><i class="fas fa-clock"></i> Preferred Time</label>
                        <input type="time" id="preferred-time" name="preferred_time" aria-label="Preferred appointment time" required>
                        <div class="error-message" id="time-error">Please select a time.</div>
                    </div>
                    <div class="form-group">
                        <label for="notes"><i class="fas fa-comment-dots"></i> Additional Notes</label>
                        <textarea id="notes" name="notes" placeholder="Any additional information" aria-label="Additional notes"></textarea>
                    </div>
                    <button type="submit"><span>Book Appointment</span></button>
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
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="packages.php">Packages</a></li>
                <li><a href="ayurvedic_therapy.php">Ayurvedic Therapy</a></li>
                <li><a href="yoga_meditation.php">Yoga & Meditation</a></li>
                <li><a href="meditation_sessions.php">Meditation Sessions</a></li>
                <li><a href="nutrition_plans.php">Nutrition Plans</a></li>
                <li><a href="physiotherapy.php">Physiotherapy</a></li>
                <li><a href="massage_therapy.php">Massage Therapy</a></li>
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
        // Update Price Display
        function updatePrice() {
            const packageSelect = document.getElementById('booking-package');
            const priceDisplay = document.getElementById('package-price');
            const prices = {
                'Swedish Massage': 'LKR 5,000',
                'Deep Tissue Massage': 'LKR 7,000',
                'Aromatherapy Massage': 'LKR 6,000'
            };

            const selectedPackage = packageSelect.value;
            if (selectedPackage && prices[selectedPackage]) {
                priceDisplay.textContent = `Price: ${prices[selectedPackage]}`;
                priceDisplay.style.display = 'block';
            } else {
                priceDisplay.textContent = 'Price: LKR 0';
                priceDisplay.style.display = 'none';
            }
        }

        // Booking Form Submission
        document.getElementById('booking-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            // Reset error messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            document.getElementById('booking-success-message').style.display = 'none';
            document.getElementById('booking-server-error').style.display = 'none';

            const submitButton = this.querySelector('button');
            submitButton.disabled = true;
            submitButton.querySelector('span').textContent = 'Submitting...';

            // Validate form
            let isValid = true;
            const name = document.getElementById('booking-name').value.trim();
            const email = document.getElementById('booking-email').value.trim();
            const package = document.getElementById('booking-package').value;
            const preferredDate = document.getElementById('preferred-date').value;
            const preferredTime = document.getElementById('preferred-time').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!name) {
                document.getElementById('booking-name-error').style.display = 'block';
                isValid = false;
            }

            if (!email || !emailRegex.test(email)) {
                document.getElementById('booking-email-error').style.display = 'block';
                isValid = false;
            }

            if (!package) {
                document.getElementById('booking-package-error').style.display = 'block';
                isValid = false;
            }

            if (!preferredDate) {
                document.getElementById('date-error').style.display = 'block';
                isValid = false;
            }

            if (!preferredTime) {
                document.getElementById('time-error').style.display = 'block';
                isValid = false;
            }

            if (!isValid) {
                submitButton.disabled = false;
                submitButton.querySelector('span').textContent = 'Book Appointment';
                return;
            }

            // Prepare form data
            const formData = new FormData(this);

            try {
                const response = await fetch('submit_booking.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (response.ok) {
                    document.getElementById('booking-success-message').textContent = result.message;
                    document.getElementById('booking-success-message').style.display = 'block';
                    document.getElementById('booking-form').reset();
                    document.getElementById('package-price').style.display = 'none';
                    setTimeout(() => location.reload(), 2000);
                } else {
                    document.getElementById('booking-server-error').textContent = result.error;
                    document.getElementById('booking-server-error').style.display = 'block';
                }
            } catch (error) {
                document.getElementById('booking-server-error').textContent = 'Thank you for your booking, Welcome!.';
                document.getElementById('booking-server-error').style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.querySelector('span').textContent = 'Book Appointment';
            }
        });

        // Newsletter Form Validation
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('newsletter-email');
            const emailError = document.getElementById('newsletter-email-error');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(emailInput.value)) {
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

        // Trigger price update on page load
        document.addEventListener('DOMContentLoaded', () => {
            const packageSelect = document.getElementById('booking-package');
            if (packageSelect.value) {
                updatePrice();
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>