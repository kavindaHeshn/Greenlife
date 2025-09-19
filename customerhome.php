<?php
session_start();
include '../configuration/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch user details
$sql = "SELECT username, email, phone, gender, role, created_at FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "User not found.";
    exit;
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - GreenLife Wellness Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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

        nav ul li .active {
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

        /* Profile Section */
        .profile-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 1200px;
            margin: 0 auto;
        }

        .profile-card {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
            margin-bottom: 2rem;
        }

        .profile-container h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .profile-details {
            font-size: 1rem;
            color: #333;
            margin-bottom: 2rem;
        }

        .profile-details p {
            margin-bottom: 0.5rem;
        }

        .profile-details p strong {
            color: var(--brown-accent);
        }

        /* Treatments Section */
        .treatments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 2rem;
        }

        .treatment-card {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .treatment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .treatment-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .treatment-content {
            padding: 1.5rem;
        }

        .treatment-content h3 {
            font-family: 'Algerian', serif;
            font-size: 1.4rem;
            color: var(--brown-accent);
            margin-bottom: 0.5rem;
        }

        .treatment-content p {
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .treatment-content button {
            background-color: var(--green-accent);
            color: #fff;
            padding: 0.7rem 1.5rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .treatment-content button:hover {
            background-color: var(--green-dark);
            transform: translateY(-2px);
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

        /* Accessibility */
        a:focus, button:focus, input:focus {
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

            .profile-container h2 {
                font-size: 2rem;
            }

            .treatment-card img {
                height: 150px;
            }

            .treatment-content h3 {
                font-size: 1.2rem;
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

            .profile-container h2 {
                font-size: 1.8rem;
            }

            .treatment-card img {
                height: 120px;
            }

            .treatment-content h3 {
                font-size: 1.1rem;
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
     <li><a href="customerhome.php"class="active">Home</a></li>
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
        <h2>Your Wellness Journey</h2>
        <p>Explore your personalized profile and book treatments tailored to your needs.</p>
    </section>

    <!-- Profile and Treatments Section -->
    <section class="profile-section">
        <div class="profile-card">
            <div class="profile-container">
                <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?> 👋</h2>
                <div class="profile-details">
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Gender:</strong> <?php echo htmlspecialchars(ucfirst($user['gender'])); ?></p>
                    <p><strong>Role:</strong> <?php echo htmlspecialchars(ucfirst($user['role'])); ?></p>
                    <p><strong>Joined:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                </div>
            </div>

            <!-- Treatments Section -->
            <h2>Available Treatments</h2>
            <div class="treatments-grid">
                <div class="treatment-card">
                    <img src="../photos/addiction-recover.webp" alt="Ayurvedic Smoke & Alcohol Detox Programme">
                    <div class="treatment-content">
                        <h3>Ayurvedic Smoke & Alcohol Detox Programme</h3>
                        <p>Break free from harmful habits with our detox programme, combining Panchakarma therapies, Abhyanga, acupuncture, herbal remedies, yoga, and meditation for holistic well-being.</p>
                        <button type="button" onclick="window.location.href='Smoke&AlcoholDetox.php'" aria-label="Book Ayurvedic Smoke & Alcohol Detox Programme">Book Now</button>
                    </div>
                </div>
                <div class="treatment-card">
                    <img src="../photos/ayurvedic-breakfast-starting-your-day-right.webp" alt="Ayurvedic Women’s Health Package">
                    <div class="treatment-content">
                        <h3>Ayurvedic Women’s Health Package</h3>
                        <p>Address women’s health concerns with Panchakarma-based therapies like Abhyanga, Nadi Sweda, Dhara Karma, and Yoni Pichu, tailored for detoxification and hormonal balance.</p>
                        <button type="button" onclick="window.location.href='womens_health.php'" aria-label="Book Ayurvedic Women’s Health Package">Book Now</button>
                    </div>
                </div>
                <div class="treatment-card">
                    <img src="../photos/mindfulness.png" alt="Ayurvedic Mindfulness Package">
                    <div class="treatment-content">
                        <h3>Ayurvedic Mindfulness Package</h3>
                        <p>Find inner peace with therapies like head, face, and foot massages, Pinda Sweda, Shirodhara, and acupuncture, plus daily yoga and meditation sessions.</p>
                        <button type="button" onclick="window.location.href='mindfulness_package.php'" aria-label="Book Ayurvedic Mindfulness Package">Book Now</button>
                    </div>
                </div>
                <div class="treatment-card">
                    <img src="../photos/opti-50_1-1-Head-Massage-2.avif" alt="Stress Relief Program">
                    <div class="treatment-content">
                        <h3>Stress Relief Program</h3>
                        <p>Experience profound relaxation with Shirodhara, Shirolepa, Shirovasti, and Sarvangadhara to alleviate stress, anxiety, depression, and burnout.</p>
                        <button type="button" onclick="window.location.href='stress_relief_program.php'" aria-label="Book Stress Relief Program">Book Now</button>
                    </div>
                </div>
                <div class="treatment-card">
                    <img src="../photos/opti-50_1-1-Kati-Wasthi.avif" alt="Immunity Booster Stay Package">
                    <div class="treatment-content">
                        <h3>Immunity Booster Stay Package</h3>
                        <p>Boost your immunity with disinfectant procedures, acupuncture, Ayurvedic medicines, vegetarian diet, and therapies like fumigation, kawalagraha, and gandusha.</p>
                        <button type="button" onclick="window.location.href='immunity_booster_stay.php'" aria-label="Book Immunity Booster Stay Package">Book Now</button>
                    </div>
                </div>
                <div class="treatment-card">
                    <img src="../photos/weightmanagement.jpg" alt="Weight Management">
                    <div class="treatment-content">
                        <h3>Weight Management</h3>
                        <p>Achieve weight loss goals with herbal powder massage, Langana diet, acupuncture, and slimming tea for sustainable Ayurvedic weight management.</p>
                        <button type="button" onclick="window.location.href='weight_management.php'" aria-label="Book Weight Management">Book Now</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" role="contentinfo">
        <div class="footer-column">
            <h3>GreenLife Wellness</h3>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="doctors.php">Doctors</a></li>
                <li><a href="OurTreatments.php">Our Treatments</a></li>
                <li><a href="packages.php">Packages</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </div>
        <div class="footer-column footer-contact">
            <h3>Contact Us</h3>
            <p>📍 Colombo, Sri Lanka</p>
            <p>📧 <a href="mailto:info@greenlife.lk">info@greenlife.lk</a></p>
            <p>📞 <a href="tel:+94769889741">+94 76 988 9741</a></p>
        </div>
        <div class="footer-column newsletter">
            <h3>Stay Connected</h3>
            <form id="newsletter-form">
                <input type="email" id="newsletter-email" placeholder="Enter your email" required aria-label="Email for newsletter">
                <p class="error-message" id="newsletter-email-error">Please enter a valid email address.</p>
                <button type="submit">Subscribe</button>
            </form>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
            </div>
        </div>
    </footer>

    <script>
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