<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - GreenLife Wellness Center</title>
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
            border: 2px solid #ffca28;
            background: linear-gradient(45deg, #b74213, #ffca28);
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
            color: #b74213;
            margin-left: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        nav ul li a {
            color: #ffca28;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: #b74213;
            transform: translateY(-2px);
        }

        nav ul li .active {
            color: #b74213;
            font-weight: 600;
            border-bottom: 2px solid #b74213;
        }

        .login-button {
            background-color: #4caf50;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .login-button:hover {
            background-color: #2e7d32;
            transform: translateY(-2px);
        }

        /* Intro Section */
        .intro-section {
            text-align: center;
            padding: 80px 20px;
            background: url('../photos/footer-gds-1.png') no-repeat center/cover;
            color: #fff;
            border-bottom: 5px solid #4caf50;
        }

        .intro-section h2 {
            font-family: 'Algerian', serif;
            font-size: 3.2rem;
            font-weight: bold;
            color: #181817ff;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .intro-section p {
            font-size: 1.2rem;
            color: #19a424ff;
        }

        /* Services Section */
        .services-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            text-align: center;
        }

        .services-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: #b74213;
            margin-bottom: 2rem;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ffca28;
            margin-bottom: 1rem;
        }

        .service-card h3 {
            font-size: 1.3rem;
            color: #b74213;
            margin-bottom: 0.5rem;
        }

        .service-card p {
            font-size: 0.95rem;
            color: #333;
            margin-bottom: 1rem;
        }

        .service-card a {
            background-color: #4caf50;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .service-card a:hover {
            background-color: #2e7d32;
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
            color: #ffca28;
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
            color: #ffca28;
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
            background-color: #4caf50;
            color: #fff;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter button:hover {
            background-color: #2e7d32;
        }

        .newsletter .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            display: none;
        }

        .social-icons a {
            color: #ffca28;
            font-size: 1.5rem;
            margin-right: 10px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-icons a:hover {
            color: #fff;
            transform: scale(1.1);
        }

        /* Login Modal */
        #login-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .login-modal-content {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            width: 300px;
            text-align: center;
        }

        .login-modal-content h2 {
            color: #b74213;
            margin-bottom: 1rem;
        }

        .login-modal-content input {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .login-modal-content button {
            background: #4caf50;
            color: #fff;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 0.5rem;
        }

        .login-modal-content button:hover {
            background: #2e7d32;
        }

        .login-modal-content .close-button {
            background: #ccc;
            margin-top: 1rem;
        }

        .login-modal-content .close-button:hover {
            background: #aaa;
        }

        /* Accessibility */
        a:focus, button:focus, input:focus {
            outline: 2px solid #ffca28;
            outline-offset: 2px;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
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

            .services-section h2 {
                font-size: 2rem;
            }

            .service-card img {
                height: 150px;
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

            .services-section h2 {
                font-size: 1.8rem;
            }

            .service-card img {
                height: 120px;
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
      <li><a href="Services.php"class="active">Services</a></li>
      <li><a href="doctors.php">Doctors contact</a></li>
      <li><a href="MedicalHistory.php"> Medical History</a></li>
      <li><a href="feedback.php">feedback</a></li>
      <li><a href="packages.php" >Packages</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Our Services</h2>
        <p>Discover holistic wellness tailored to rejuvenate your mind, body, and soul.</p>
    </section>

    <!-- Services Section -->
    <section class="services-section">
        <h2>Explore Our Wellness Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <img src="../photos/ayurvedic-therapy.jpeg" alt="Ayurvedic Therapy">
                <h3>Ayurvedic Therapy</h3>
                <p>Experience traditional Sri Lankan healing with personalized herbal treatments and therapies to restore balance and vitality.</p>
                <a href="ayurvedic_therapy.php">Learn More</a>
            </div>
            <div class="service-card">
                <img src="../photos/yoga-session.jpg" alt="Yoga Classes">
                <h3>Yoga Classes</h3>
                <p>Join our expert-led yoga sessions to enhance flexibility, strength, and mental clarity through mindful practice.</p>
                <a href="yoga.php">Learn More</a>
            </div>
            <div class="service-card">
                <img src="../photos/meditation-area.jpg" alt="Meditation Sessions">
                <h3>Meditation Sessions</h3>
                <p>Find inner peace with guided meditation sessions designed to reduce stress and promote mindfulness.</p>
                <a href="meditation_sessions.php">Learn More</a>
            </div>
            <div class="service-card">
                <img src="../photos/nutrition-consultation.webp" alt="Nutrition Consultation">
                <h3>Nutrition Consultation</h3>
                <p>Receive personalized dietary advice to support your health goals with our expert nutritionists.</p>
                <a href="nutrition.php">Learn More</a>
            </div>
            <div class="service-card">
                <img src="../photos/physiotherapy.jpg" alt="Physiotherapy">
                <h3>Physiotherapy</h3>
                <p>Recover and regain mobility with tailored physiotherapy sessions to address pain and physical limitations.</p>
                <a href="physiotherapy.php">Learn More</a>
            </div>
            <div class="service-card">
                <img src="../photos/massage-therapy.webp" alt="Massage Therapy">
                <h3>Massage Therapy</h3>
                <p>Relax and rejuvenate with therapeutic massages to relieve tension and promote overall well-being.</p>
                <a href="massage.php">Learn More</a>
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
                <li><a href="Contact.php">Contact Us</a></li>
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
                <input type="email" id="email-input" placeholder="Enter your email" required aria-label="Email for newsletter">
                <p class="error-message" id="email-error">Please enter a valid email address.</p>
                <button type="submit">Subscribe</button>
            </form>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
            </div>
        </div>
    </footer>

    <!-- Login Modal -->
    <div id="login-modal">
        <div class="login-modal-content">
            <h2>Login</h2>
            <form id="login-form">
                <input type="text" id="username" placeholder="Username" required>
                <input type="password" id="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <button class="close-button" onclick="closeLoginModal()">Close</button>
        </div>
    </div>

    <script>
        // Newsletter Form Validation
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = document.getElementById('email-input');
            const emailError = document.getElementById('email-error');
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

        // Login Modal Functions
        function showLoginModal() {
            document.getElementById('login-modal').style.display = 'flex';
        }

        function closeLoginModal() {
            document.getElementById('login-modal').style.display = 'none';
        }

        // Login Form Submission
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            alert(`Login attempt with Username: ${username}`);
            closeLoginModal();
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