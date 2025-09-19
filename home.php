<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenLife Wellness Center - Holistic Wellness in Colombo</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
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
        }

        /* Navigation Bar */
        header {
            background-color: #fff; /* White background */
            color: #333;
            padding: 1rem 0;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav {
            max-width: 100%; /* Full-screen width */
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
            height: 70px; /* Slightly larger logo */
            border-radius: 8px;
            border: 2px solid #ffca28; /* Yellow border */
            background: linear-gradient(45deg, #b74213, #ffca28); /* Red-to-yellow gradient */
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
            color: #b74213; /* Red for brand name */
            margin-left: 10px;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 25px; /* Increased gap for better spacing */
        }

        nav ul li a {
            color: #ffca28; /* Yellow links */
            text-decoration: none;
            font-size: 1.1rem; /* Slightly larger font */
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        nav ul li a:hover {
            color: #b74213; /* Red on hover */
            transform: translateY(-2px);
        }

        nav ul li .active {
            color: #b74213; /* Red for active link */
            font-weight: 600;
            border-bottom: 2px solid #b74213;
        }

        .login-button {
            background-color: #4caf50; /* Green for motivation */
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .login-button:hover {
            background-color: #2e7d32; /* Darker green */
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: #fff;
            padding: 20px;
            margin-top: 80px;
            overflow: hidden;
        }

        .hero video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.17));
            z-index: 0;
        }

        .hero-content {
            max-width: 800px;
            z-index: 1;
            animation: fadeIn 1.5s ease-in-out;
        }

        .hero-content h1 {
            font-family: 'Algerian', serif; /* Algerian font */
            font-size: 4rem; /* Larger for prominence */
            font-weight: bold; /* Bold as requested */
            color: #ffca28; /* Yellow for vibrancy */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            margin-bottom: 1rem;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: #fff;
        }

        .cta-button {
            background-color: #b74213; /* Red for motivation */
            color: #fff;
            padding: 0.8rem 1.5rem;
            border-radius: 25px;
            text-decoration: none;
            font-size: 1rem;
            margin-top: 1.5rem;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .cta-button:hover {
            background-color: #8a2f0e; /* Darker red */
            transform: scale(1.05);
        }

        /* Wellness Section */
        .wellness-section {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #f9f9f9, #e8f5e9); /* Green gradient */
        }

        .wellness-text {
            flex: 1;
            padding: 20px;
            min-width: 300px;
        }

        .wellness-text h2 {
            font-size: 2.5rem;
            color: #b74213; /* Red for energy */
            margin-bottom: 1rem;
        }

        .wellness-text p {
            font-size: 1rem;
            color: #333;
            line-height: 1.8;
        }

        .wellness-text ul {
            list-style: none;
            margin: 1rem 0;
            padding-left: 20px;
        }

        .wellness-text ul li {
            font-size: 1rem;
            color: #333;
            position: relative;
            margin-bottom: 0.5rem;
        }

        .wellness-text ul li::before {
            content: "🌿"; /* Green leaf emoji */
            position: absolute;
            left: -20px;
            color: #4caf50;
        }

        .wellness-image {
            flex: 1;
            min-width: 300px;
            padding: 20px;
        }

        .wellness-image img {
            width: 100%;
            max-height: 450px; /* Larger image */
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .wellness-image img:hover {
            transform: scale(1.05);
        }

        /* Services Section */
        .services {
            padding: 60px 20px;
            background-color: #fff;
        }

        .services h2 {
            text-align: center;
            font-size: 2.5rem;
            color: #b74213; /* Red for motivation */
            margin-bottom: 2rem;
        }

        .service-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); /* Larger cards */
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .service-card {
            background-color: #e8f5e9; /* Light green */
            padding: 1.8rem;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .service-card h3 {
            font-size: 1.5rem;
            color: #ffca28; /* Yellow for vibrancy */
            margin-bottom: 0.5rem;
        }

        .service-card img {
            width: 100%;
            height: 200px; /* Larger images */
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }

        .service-card p {
            font-size: 0.95rem;
            color: #333;
        }

        /* Footer */
        footer {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.42)), url('https://via.placeholder.com/1920x300?text=Footer+Image');
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
            color: #ffca28; /* Yellow for headings */
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
            color: #ffca28; /* Yellow on hover */
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

        .newsletter button {
            background-color: #4caf50; /* Green for motivation */
            color: #fff;
            padding: 0.7rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .newsletter button:hover {
            background-color: #2e7d32; /* Darker green */
        }

        .social-icons a {
            color: #ffca28; /* Yellow for social icons */
            font-size: 1.5rem;
            margin-right: 10px;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-icons a:hover {
            color: #fff;
            transform: scale(1.1);
        }

        .bottom-bar {
            background-color: #111;
            color: #ccc;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
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

            .hero-content h1 {
                font-size: 3rem;
            }

            .wellness-image img {
                max-height: 350px;
            }

            .service-card img {
                height: 150px;
            }

            .services h2 {
                font-size: 2rem;
            }

            footer {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .wellness-image img {
                max-height: 300px;
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
                <li><a href="home.php" class="active">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="OurTreatments.php">Testimonials</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php" class="login-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <video autoplay muted loop playsinline>
            <source src="../photos/grok-video-d22b0db4-0fd1-49ad-880b-2743386bdcfb.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>GreenLife Wellness Center</h1>
            <p>Embrace a healthier you with our holistic wellness programs in Colombo.</p>
           
        </div>
    </section>

    <!-- Wellness Section -->
    <section class="wellness-section" id="about" aria-labelledby="wellness-heading">
        <div class="wellness-text">
            <h2 id="wellness-heading">About GreenLife</h2>
            <p>
                Located in the heart of Colombo, GreenLife Wellness Center is your sanctuary for healing, relaxation, and transformation. Guided by the timeless wisdom of traditional Ayurveda and enhanced by modern holistic health practices, we are dedicated to nurturing your overall well-being.
            </p>
            <p>
                At GreenLife, you can explore a variety of personalized wellness programs — from revitalizing treatments that restore your energy to calming therapies that ease stress and bring balance to your daily life.
            </p>
            <ul>
                <li>Authentic Ayurvedic therapies</li>
                <li>Yoga & Meditation sessions for inner peace</li>
                <li>Tailored nutritional guidance for a healthier lifestyle</li>
                <li>Professional physiotherapy for recovery and strength</li>
                <li>Relaxing massage treatments to soothe body and mind</li>
            </ul>
            <p>
                Step into GreenLife and begin a holistic journey that harmonizes your mind, body, and spirit, leading you toward lasting wellness and tranquility.
            </p>
        </div>
        <div class="wellness-image">
            <img src="../photos/AboutGreenLife.png" alt="Wellness Image">
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services" aria-labelledby="services-heading">
        <h2 id="services-heading">Our Services</h2>
        <div class="service-grid">
            <div class="service-card">
                <h3>Ayurvedic Therapy</h3>
                <img src="../photos/AyurvedicTherapy.png" alt="Ayurvedic Therapy">
                <p>Restore balance with ancient healing techniques.</p>
            </div>
            <div class="service-card">
                <h3>Yoga & Meditation</h3>
                <img src="../photos/yoga.png" alt="Yoga & Meditation">
                <p>Boost mindfulness and flexibility with our classes.</p>
            </div>
            <div class="service-card">
                <h3>Nutrition Consultation</h3>
                <img src="../photos/nutrition.png" alt="Nutrition Consultation">
                <p>Personalized diet plans for your wellness goals.</p>
            </div>
            <div class="service-card">
                <h3>Physiotherapy</h3>
                <img src="../photos/Physiotherapy.png" alt="Physiotherapy">
                <p>Expert care to enhance mobility and recovery.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact" role="contentinfo">
        <div class="footer-column">
            <h3>GreenLife Wellness</h3>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#testimonials">Testimonials</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </div>
        <div class="footer-column">
            <h3>Contact Us</h3>
            <p>📍 Colombo, Sri Lanka</p>
            <p>📧 <a href="mailto:info@greenlife.lk">info@greenlife.lk</a></p>
            <p>📞 <a href="tel:+94769889741">+94 76 988 9741</a></p>
        </div>
        <div class="footer-column newsletter">
            <h3>Stay Connected</h3>
            <form id="newsletter-form">
                <input type="email" id="email" placeholder="Enter your email" required aria-label="Email for newsletter">
                <button type="submit">Subscribe</button>
            </form>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
    </footer>

 

    <!-- Login Modal -->
    <div id="login-modal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
        <div style="background: #fff; padding: 2rem; border-radius: 10px; width: 300px; text-align: center;">
            <h2 style="color: #b74213;">Login</h2>
            <form id="login-form">
                <input type="text" id="username" placeholder="Username" required style="width: 100%; padding: 0.5rem; margin: 0.5rem 0; border-radius: 5px; border: 1px solid #ccc;">
                <input type="password" id="password" placeholder="Password" required style="width: 100%; padding: 0.5rem; margin: 0.5rem 0; border-radius: 5px; border: 1px solid #ccc;">
                <button type="submit" style="background: #4caf50; color: #fff; padding: 0.5rem; border: none; border-radius: 5px; cursor: pointer;">Login</button>
            </form>
            <button onclick="closeLoginModal()" style="margin-top: 1rem; background: #ccc; padding: 0.5rem; border: none; border-radius: 5px; cursor: pointer;">Close</button>
        </div>
    </div>

    <script>
        // Newsletter Form Submission
        document.getElementById('newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            alert(`Thank you for subscribing, ${email}!`);
            this.reset();
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
            const password = document.getElementById('password').value;
            alert(`Login attempt with Username: ${username}`);
            closeLoginModal();
            // Add actual authentication logic here (e.g., API call)
        });

        // Smooth Scroll for Navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>