<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - GreenLife Wellness Center</title>
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
            background: url('../photos/about-header.jpg') no-repeat center/cover;
            color: #fff;
            border-bottom: 5px solid #4caf50;
        }

        .intro-section h2 {
            font-family: 'Algerian', serif;
            font-size: 3.2rem;
            font-weight: bold;
            color: #d7d7cbff;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .intro-section p {
            font-size: 1.2rem;
            color: #19a424ff;
        }

        /* About Section */
        .about-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            text-align: center;
        }

        .about-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: #b74213;
            margin-bottom: 2rem;
        }

        .about-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }

        .about-text {
            flex: 1 1 50%;
            text-align: left;
        }

        .about-text p {
            font-size: 1rem;
            color: #333;
            line-height: 1.8;
            margin-bottom: 1rem;
        }

        .about-image {
            flex: 1 1 40%;
            max-width: 450px;
        }

        .about-image img {
            width: 100%;
            max-height: 450px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .about-image img:hover {
            transform: scale(1.05);
        }

        /* Gallery Section */
        .gallery-section {
            padding: 60px 20px;
            background-color: #fff;
            text-align: center;
        }

        .gallery-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: #b74213;
            margin-bottom: 2rem;
        }

        .slideshow-container {
            max-width: 800px;
            position: relative;
            margin: 0 auto;
        }

        .slide {
            display: none;
        }

        .slide img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #ffca28;
        }

        .caption {
            color: #333;
            font-size: 1rem;
            padding: 8px 12px;
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 5px;
            margin-top: 10px;
        }

        .prev, .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: #ffca28;
            font-weight: bold;
            font-size: 18px;
            transition: 0.3s ease;
            border-radius: 0 3px 3px 0;
            user-select: none;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .next {
            right: 0;
            border-radius: 3px 0 0 3px;
        }

        .prev:hover, .next:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .dots-container {
            text-align: center;
            padding: 10px 0;
        }

        .dot {
            cursor: pointer;
            height: 15px;
            width: 15px;
            margin: 0 5px;
            background-color: #bbb;
            border-radius: 50%;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        .dot.active, .dot:hover {
            background-color: #b74213;
        }

        .fade {
            animation: fadeIn 0.5s;
        }

        /* Team Section */
        .team-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            text-align: center;
        }

        .team-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: #b74213;
            margin-bottom: 2rem;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .team-card {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .team-card:hover {
            transform: translateY(-5px);
        }

        .team-card img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffca28;
            margin-bottom: 1rem;
        }

        .team-card h3 {
            font-size: 1.3rem;
            color: #b74213;
            margin-bottom: 0.5rem;
        }

        .team-card p {
            font-size: 0.95rem;
            color: #333;
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

        .bottom-bar {
            background-color: #111;
            color: #ccc;
            text-align: center;
            padding: 1rem;
            font-size: 0.9rem;
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

            .about-section h2, .gallery-section h2, .team-section h2 {
                font-size: 2rem;
            }

            .about-content {
                flex-direction: column;
                text-align: center;
            }

            .about-text {
                text-align: center;
            }

            .about-image {
                max-width: 100%;
            }

            .slide img {
                height: 300px;
            }

            .team-card img {
                width: 100px;
                height: 100px;
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

            .about-section h2, .gallery-section h2, .team-section h2 {
                font-size: 1.8rem;
            }

            .slide img {
                height: 200px;
            }

            .team-card img {
                width: 80px;
                height: 80px;
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
                <li><a href="about.php" class="active">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="OurTreatments.php">Testimonials</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="login.php" class="login-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Who We Are</h2>
        <p>Bringing holistic wellness to life — naturally, mindfully, beautifully.</p>
    </section>

    <!-- About Section -->
    <section class="about-section">
        <h2>About GreenLife Wellness Center</h2>
        <div class="about-content">
            <div class="about-text">
                <p>
                    GreenLife Wellness Center, located in the heart of Colombo, Sri Lanka, is dedicated to promoting holistic wellness through a blend of traditional and modern practices. Our mission is to empower individuals to achieve optimal health and well-being through personalized services, including Ayurvedic therapy, yoga, meditation, nutrition consultation, physiotherapy, and massage therapy.
                </p>
                <p>
                    Founded with a passion for holistic health, our team of experienced therapists and wellness consultants is committed to providing exceptional care in a serene and welcoming environment. Join us on a journey to rejuvenate your mind, body, and soul.
                </p>
            </div>
            <div class="about-image">
                <img src="../photos/wellness-center.png" alt="GreenLife Wellness Center Interior">
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="gallery-section">
        <h2>Our Gallery</h2>
        <div class="slideshow-container">
            <!-- Slides -->
            <div class="slide fade">
                <img src="../photos/Yoga Session.jpg" alt="Yoga Session at GreenLife">
                <div class="caption">Yoga Session at GreenLife</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Aurvedictheropyroom.jpg" alt="Ayurvedic Therapy Room">
                <div class="caption">Ayurvedic Therapy Room</div>
            </div>
            <div class="slide fade">
                <img src="../photos/meditation area.jpg" alt="Meditation Area">
                <div class="caption">Meditation Area</div>
            </div>
            <div class="slide fade">
                <img src="../photos/nutrishion consultation.jpg" alt="Nutrition Consultation">
                <div class="caption">Nutrition Consultation</div>
            </div>
            <div class="slide fade">
                <img src="../photos/massage theropy.jpg" alt="Massage Therapy Session">
                <div class="caption">Massage Therapy Session</div>
            </div>
            <div class="slide fade">
                <img src="../photos/AyurvedicSpecialist.jpg" alt="Dr. Nimal Perera">
                <div class="caption">Dr. Nimal Perera - Ayurvedic Specialist</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Nutrition Consultant.jpg" alt="Dr. Sangeetha Wijesinghe">
                <div class="caption">Dr. Sangeetha Wijesinghe - Nutrition Consultant</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Holistic Medicine Expert.png" alt="Dr. Priya Fernando">
                <div class="caption">Dr. Priya Fernando - Holistic Medicine Expert</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Physiotherapist.png" alt="Dr. Kamal Silva">
                <div class="caption">Dr. Kamal Silva - Physiotherapist</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Wellness Consultant.png" alt="Dr. Anjali Rajapakse">
                <div class="caption">Dr. Anjali Rajapakse - Wellness Consultant</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Anura Silva.jpg" alt="Anura Silva">
                <div class="caption">Anura Silva - Massage Therapist</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Massage Therapist.jpg" alt="Kumari Fernando">
                <div class="caption">Kumari Fernando - Yoga Instructor</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Physiotherapist.jpg" alt="Ravi Jayawardena">
                <div class="caption">Ravi Jayawardena - Physiotherapist</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Samanthi Perera.jpg" alt="Samanthi Perera">
                <div class="caption">Samanthi Perera - Ayurvedic Therapist</div>
            </div>
            <div class="slide fade">
                <img src="../photos/Meditation Coach.jpg" alt="Nimali Wickramasinghe">
                <div class="caption">Nimali Wickramasinghe - Meditation Coach</div>
            </div>
            <!-- Navigation Arrows -->
            <a class="prev" onclick="plusSlides(-1)" aria-label="Previous slide">&#10094;</a>
            <a class="next" onclick="plusSlides(1)" aria-label="Next slide">&#10095;</a>
        </div>
        <!-- Dots -->
        <div class="dots-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
            <span class="dot" onclick="currentSlide(6)"></span>
            <span class="dot" onclick="currentSlide(7)"></span>
            <span class="dot" onclick="currentSlide(8)"></span>
            <span class="dot" onclick="currentSlide(9)"></span>
            <span class="dot" onclick="currentSlide(10)"></span>
            <span class="dot" onclick="currentSlide(11)"></span>
            <span class="dot" onclick="currentSlide(12)"></span>
            <span class="dot" onclick="currentSlide(13)"></span>
            <span class="dot" onclick="currentSlide(14)"></span>
            <span class="dot" onclick="currentSlide(15)"></span>
        </div>
    </section>

    

    <!-- Therapists Section -->
    <section class="team-section" id="therapists">
        <h2>Our Therapists</h2>
        <div class="team-grid">
            
            <div class="team-card">
                <img src="../photos/Kumari Fernando.webp" alt="Kumari Fernando">
                <h3>Kumari Fernando</h3>
                <p>Yoga Instructor</p>
            </div>
            <div class="team-card">
                <img src="../photos/Anura Silva.jpg" alt="Ravi Jayawardena">
                <h3>Ravi Jayawardena</h3>
                <p>Physiotherapist</p>
            </div>
            <div class="team-card">
                <img src="../photos/Samanthi Perera.jpg" alt="Samanthi Perera">
                <h3>Samanthi Perera</h3>
                <p>Ayurvedic Therapist</p>
            </div>
            <div class="team-card">
                <img src="../photos/Nimal Wickramasinghe.jpg" alt="Nimali Wickramasinghe">
                <h3>Nimali Wickramasinghe</h3>
                <p>Meditation Coach</p>
            </div>
            <div class="team-card">
                <img src="../photos/Chaminda Dsilva.jpg" alt="Chaminda de Silva">
                <h3>Chaminda de Silva</h3>
                <p>Massage Therapist</p>
            </div>
            <div class="team-card">
                <img src="../photos/Dilani Gunawardana.jpg" alt="Dilani Gunawardena">
                <h3>Dilani Gunawardena</h3>
                <p>Yoga Instructor</p>
            </div>
            <div class="team-card">
                <img src="../photos/Ruwan Disanayaka.jpg" alt="Ruwan Dissanayake">
                <h3>Ruwan Dissanayake</h3>
                <p>Physiotherapist</p>
            </div>
            <div class="team-card">
                <img src="../photos/Tharushi Fernando.jpg" alt="Tharushi Fernando">
                <h3>Tharushi Fernando</h3>
                <p>Ayurvedic Therapist</p>
            </div>
            <div class="team-card">
                <img src="../photos/Lakmal Wijesinghe.jpg" alt="Lakmal Wijesinghe">
                <h3>Lakmal Wijesinghe</h3>
                <p>Meditation Coach</p>
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

        // Slideshow Functionality
        let slideIndex = 1;
        let slideInterval;

        showSlides(slideIndex);
        startSlideShow();

        function plusSlides(n) {
            showSlides(slideIndex += n);
            resetSlideShow();
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
            resetSlideShow();
        }

        function showSlides(n) {
            let i;
            let slides = document.getElementsByClassName("slide");
            let dots = document.getElementsByClassName("dot");

            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }

            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }

            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }

            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }

        function startSlideShow() {
            slideInterval = setInterval(() => {
                plusSlides(1);
            }, 3000); // Change slide every 3 seconds
        }

        function resetSlideShow() {
            clearInterval(slideInterval);
            startSlideShow();
        }
    </script>
</body>
</html>