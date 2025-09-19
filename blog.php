<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - GreenLife Wellness Center</title>
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
            --fullSize: 100%;
            --space-xl: 2rem;
            --space-l: 1.5rem;
            --space-m: 1.25rem;
            --space: 1rem;
            --space-ss: 0.75rem;
            --space-s: 0.5rem;
            --space-xs: 0.25rem;
            --fs-l: 1.4375rem;
            --fs-m: 1.25rem;
            --fs-default: 1rem;
            --fs-s: 0.9rem;
            --fs-xs: 0.875rem;
            --clr-default: #fff;
            --green-accent: #4caf50;
            --green-dark: #2e7d32;
            --yellow-accent: #ffca28;
            --brown-accent: #b74213;
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

        .login-button {
            background-color: var(--green-accent);
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 20px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .login-button:hover {
            background-color: var(--green-dark);
            transform: translateY(-2px);
        }

        /* Intro Section */
        .intro-section {
            text-align: center;
            padding: 80px 20px;
            background: url('../photos/petrissage+massage+a+complete+guide.webp') no-repeat center/cover;
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

        /* Blog Section */
        .blog-section {
            padding: 60px 20px;
            background-color: #e8f5e9;
            text-align: center;
        }

        .blog-section h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            margin-bottom: 2rem;
        }

        .blog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            --header-size--min: 12.75rem;
            --header-size--max: 19rem;
            --width: 20rem;
            --height: 27rem;
            --easing: cubic-bezier(0.5, 0, 0.2, 1);
            --easing1: cubic-bezier(0.4, 0.3, 0.65, 1);
            --easing2: cubic-bezier(0.8, 0, 0.6, 1);
            --easing3: cubic-bezier(0, 0.2, 0.25, 1);
            display: flex;
            flex-direction: column;
            inline-size: var(--width);
            block-size: var(--height);
            border-radius: 0.125em;
            background: #fff;
            overflow: hidden;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px,
                rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;
        }

        .card:hover {
            transition: all var(--anim-time--hi) var(--easing1);
            border: 0;
            box-shadow: -0.375rem 0 1px -1px var(--green-accent),
                -3.5rem 0 3.125rem -1.125rem #e8f5e9;
        }

        .card header {
            display: flex;
            height: var(--header-size--max);
            position: relative;
            overflow: hidden;
            transition: transform var(--anim-time--med) ease;
            isolation: isolate;
        }

        .card header::before,
        .card header::after {
            content: "";
            position: absolute;
            inset: 0;
            transition-property: opacity, transform;
            transition-duration: var(--anim-time--med), var(--anim-time--med);
            transition-timing-function: ease, ease;
        }

        .card header::before {
            background: linear-gradient(to top,
                hsla(0, 0%, 0%, 0.8) 0%,
                hsla(0, 0%, 0%, 0.7) 12%,
                hsla(0, 0%, 0%, 0.2) 41.6%,
                hsla(0, 0%, 0%, 0.125) 50%,
                hsla(0, 0%, 0%, 0.01) 59.9%,
                hsla(0, 0%, 0%, 0) 100%);
            opacity: 0;
            z-index: 4;
        }

        .card header::after {
            background-size: cover;
            background-position: center;
        }

        .card__content:hover header {
            transform: translateY(calc(var(--header-size--min) - var(--header-size--max)));
        }

        .card__content:hover header::after {
            transform: translateY(calc(var(--header-size--max) - var(--header-size--min))) scale(1.2);
        }

        .card__content:hover header::before {
            opacity: 0.8;
        }

        .header__caption {
            z-index: 10;
            display: flex;
            width: 100%;
            flex-direction: column;
            align-self: flex-end;
            gap: var(--space-xl);
            opacity: 0;
            transform: translateY(100%);
            transition: transform var(--anim-time--hi) linear,
                opacity var(--anim-time--hi) linear;
        }

        .card__content:hover .header__caption {
            transform: translateY(0);
            opacity: 1;
            transition: opacity var(--anim-time--hi) var(--easing),
                transform var(--anim-time--lo) var(--easing2);
        }

        .header__tag {
            width: max-content;
            color: var(--clr-default);
        }

        .tag--primary {
            margin-inline: var(--space);
            font-size: var(--fs-l);
            font-family: 'Algerian', serif;
        }

        .tag--secondary {
            font: 600 0.9rem/1 'Poppins', sans-serif;
            color: var(--yellow-accent);
            background: linear-gradient(to bottom, #e8f5e9, 20%, var(--clr-default) 80%);
            padding: 0.5rem 1.25em;
            letter-spacing: 2px;
            border-radius: 0 0.35rem 0 0;
            box-shadow: 1px -1px 0 2px var(--green-accent);
        }

        .card__body {
            margin-inline: var(--space);
            height: calc(var(--header-size--max) - var(--header-size--min));
            padding-block-end: var(--space-s);
            transition: transform var(--anim-time--med) ease;
            font-family: 'Poppins', sans-serif;
        }

        .card__content:hover .card__body {
            transform: translateY(calc(var(--header-size--min) - var(--header-size--max)));
        }

        .title--primary {
            font-size: var(--fs-l);
            font-weight: 600;
            color: var(--brown-accent);
            padding-block: var(--space-l) var(--space-s);
        }

        .description {
            font-size: var(--fs-default);
            max-width: 33ch;
            color: #333;
            opacity: 0;
            transition: opacity var(--anim-time--hi) var(--easing),
                transform var(--anim-time--hi) var(--easing2);
        }

        .card__content:hover .description {
            opacity: 1;
            transform: translateY(1.5rem);
            transition: opacity var(--anim-time--hi) var(--easing2),
                transform var(--anim-time--hi) var(--easing2);
        }

        .footer {
            display: flex;
            align-items: center;
            margin-top: auto;
            margin-inline: var(--space);
            height: calc(var(--space-m) * 3);
        }

        .link__text {
            width: max-content;
            padding: 0.35em 1.25em;
            font-size: var(--fs-s);
            font-weight: 900;
            color: var(--green-accent);
            background-color: #e8f5e9;
            border-radius: 8px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .link__text:hover {
            background-color: var(--green-dark);
            color: #fff;
            transform: translateY(-2px);
        }

        .expand__indicator {
            transition: opacity var(--anim-time--lo) var(--easing);
        }

        .card__content:hover .expand__indicator {
            opacity: 0;
            transition: opacity var(--anim-time--lo) var(--easing3);
        }

        .footer__navigation {
            display: inline-flex;
            align-items: center;
            height: 100%;
            gap: var(--space);
            justify-content: right;
        }

        .icon__link {
            display: inline-flex;
            height: max-content;
            width: max-content;
            justify-content: center;
            align-items: center;
            color: var(--brown-accent);
            font-size: 1rem;
            background: 0;
            border: 0;
        }

        .icon__link:hover {
            animation: pulse var(--anim-time--med) var(--easing1);
            animation-iteration-count: 2;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.3); }
        }

        .icon__link:focus-within {
            color: var(--green-accent);
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
            color: var(--brown-accent);
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
            background: var(--green-accent);
            color: #fff;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 0.5rem;
        }

        .login-modal-content button:hover {
            background: var(--green-dark);
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
            outline: 2px solid var(--yellow-accent);
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

            .blog-section h2 {
                font-size: 2rem;
            }

            .card {
                --width: 100%;
                --height: 24rem;
                --header-size--min: 10rem;
                --header-size--max: 16rem;
            }

            .title--primary {
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

            .blog-section h2 {
                font-size: 1.8rem;
            }

            .card {
                --width: 100%;
                --height: 22rem;
                --header-size--min: 9rem;
                --header-size--max: 14rem;
            }

            .title--primary {
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
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="OurTreatments.php">Testimonials</a></li>
                <li><a href="blog.php" class="active">Blog</a></li>
                <li><a href="Contact.php">Contact Us</a></li>
                <li><a href="login.php" class="login-button">Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Our Blog</h2>
        <p>Explore wellness tips, insights, and updates from our AI doctors at GreenLife Wellness Center.</p>
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <h2>Latest Posts</h2>
        <div class="blog-grid">
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog1.webp');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Ayurveda</span>
                        <span class="header__tag tag--secondary">Dr. AyuBot</span>
                    </figcaption>
                    <style>header[style*="blog1.webp"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">The Benefits of Ayurvedic Wellness</h1>
                    <p class="description">Discover how Ayurvedic practices can restore balance and promote holistic health in your daily life.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post1.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog2.jpg');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Yoga</span>
                        <span class="header__tag tag--secondary">Dr. YogaMind</span>
                    </figcaption>
                    <style>header[style*="blog2.jpg"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">Yoga for Stress Relief</h1>
                    <p class="description">Learn simple yoga poses to reduce stress and improve mental clarity with our expert tips.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post2.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog3.avif');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Nutrition</span>
                        <span class="header__tag tag--secondary">Dr. NutriBot</span>
                    </figcaption>
                    <style>header[style*="blog3.avif"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">Nutrition for a Healthier You</h1>
                    <p class="description">Explore our guide to balanced nutrition and how it supports your wellness journey.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post3.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog4.jpg');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Meditation</span>
                        <span class="header__tag tag--secondary">Dr. ZenAI</span>
                    </figcaption>
                    <style>header[style*="blog4.jpg"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">Meditation Techniques for Beginners</h1>
                    <p class="description">Start your meditation practice with these easy techniques to find inner peace.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post4.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog5.jpg');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Physiotherapy</span>
                        <span class="header__tag tag--secondary">Dr. PhysioBot</span>
                    </figcaption>
                    <style>header[style*="blog5.jpg"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">Why Physiotherapy Matters</h1>
                    <p class="description">Understand how physiotherapy can aid recovery and improve physical health.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post5.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
            <article class="card card__content">
                <header style="--bg-image: url('../photos/blog6.jpg');">
                    <figcaption class="header__caption" role="presentation">
                        <span class="header__tag tag--primary">Massage</span>
                        <span class="header__tag tag--secondary">Dr. RelaxAI</span>
                    </figcaption>
                    <style>header[style*="blog6.jpg"]::after { background-image: var(--bg-image); }</style>
                </header>
                <main class="card__body">
                    <h1 class="title--primary">The Power of Massage Therapy</h1>
                    <p class="description">Learn how massage therapy can relieve tension and promote relaxation.</p>
                </main>
                <footer class="footer">
                    <div class="expand__indicator">
                        <a href="blog-post6.html" class="link__text">Read More</a>
                    </div>
                    <div class="footer__navigation">
                        <button class="icon__link" aria-label="Like this post"><i class="fas fa-heart"></i></button>
                        <button class="icon__link" aria-label="Share this post"><i class="fas fa-share-nodes"></i></button>
                    </div>
                </footer>
            </article>
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