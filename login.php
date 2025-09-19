<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GreenLife Wellness Center</title>
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

        /* Intro Section */
        .intro-section {
            text-align: center;
            padding: 80px 20px;
            background: url('../photos/about-header.jpg') no-repeat center/cover;
            color: #fff;
            border-bottom: 5px solid var(--green-accent);
        }

        .intro-section h2 {
            font-family: 'Algerian', serif;
            font-size: 3.2rem;
            font-weight: bold;
            color: #f0f0ebff;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .intro-section p {
            font-size: 1.2rem;
            color: #19a424;
        }

        /* Login Form Section */
        .login-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
        }

        .login-container h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login-container input {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 1rem;
            transition: border-color 0.3s ease;
        }

        .login-container input:focus {
            border-color: var(--yellow-accent);
            outline: none;
        }

        .login-container input.invalid {
            border-color: #ff4444;
        }

        .login-container button {
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

        .login-container button:hover {
            background-color: var(--green-dark);
            transform: translateY(-2px);
        }

        .signup-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            font-size: 0.9rem;
            color: var(--green-accent);
            text-decoration: none;
            font-weight: 500;
        }

        .signup-link:hover {
            color: var(--green-dark);
            text-decoration: underline;
        }

        .error-message {
            color: #ff4444;
            font-size: 0.9rem;
            text-align: center;
            margin-bottom: 1rem;
            display: block;
        }

        .client-error-message {
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

            .login-container h2 {
                font-size: 2rem;
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

            .login-container h2 {
                font-size: 1.8rem;
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
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="testimonials.php">Testimonials</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Login to GreenLife Wellness</h2>
        <p>Access your personalized wellness journey by logging into your account.</p>
    </section>

    <!-- Login Form Section -->
    <section class="login-section" aria-labelledby="login-heading">
        <div class="login-container">
            <h2 id="login-heading">Login to Your Account</h2>
            <?php
                // Display error messages from login.php
                if (isset($_GET['error'])) {
                    echo '<div class="error-message">' . htmlspecialchars($_GET['error']) . '</div>';
                }
            ?>
            <form id="login-form" action="../backend/login.php" method="post">
                <input type="text" id="username" name="username" placeholder="Username or Email" aria-label="Username or Email" required>
                <p class="client-error-message" id="username-error">Username must be at least 3 characters long.</p>
                <input type="password" id="password" name="password" placeholder="Password" aria-label="Password" required>
                <p class="client-error-message" id="password-error">Password must be at least 6 characters long.</p>
                <button type="submit">Login</button>
                <a href="register.php" class="signup-link">Don't have an account? Sign up</a>
            </form>
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
        // Login Form Validation
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Username validation
            const username = document.getElementById('username');
            const usernameError = document.getElementById('username-error');
            if (username.value.length < 3) {
                username.classList.add('invalid');
                usernameError.style.display = 'block';
                isValid = false;
            } else {
                username.classList.remove('invalid');
                usernameError.style.display = 'none';
            }

            // Password validation
            const password = document.getElementById('password');
            const passwordError = document.getElementById('password-error');
            if (password.value.length < 6) {
                password.classList.add('invalid');
                passwordError.style.display = 'block';
                isValid = false;
            } else {
                password.classList.remove('invalid');
                passwordError.style.display = 'none';
            }

            // Submit form if valid
            if (isValid) {
                this.submit();
            }
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