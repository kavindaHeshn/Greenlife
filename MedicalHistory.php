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
$user_phone = '';
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT username, email, phone FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $user_name = htmlspecialchars($user['username']);
        $user_email = htmlspecialchars($user['email']);
        $user_phone = htmlspecialchars($user['phone'] ?? '');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical History - GreenLife Wellness Center</title>
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

        /* Medical History Form Section */
        .medical-form {
            padding: 60px 20px;
            background-color: #e8f5e9;
            max-width: 1200px;
            margin: 0 auto;
        }

        .form-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border: 2px solid var(--yellow-accent);
        }

        .medical-form h2 {
            font-family: 'Algerian', serif;
            font-size: 2.5rem;
            color: var(--brown-accent);
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group h3 {
            font-family: 'Algerian', serif;
            font-size: 1.8rem;
            color: var(--brown-accent);
            margin-bottom: 1rem;
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

        .form-group input:not([type="checkbox"]),
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus:not([type="checkbox"]),
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--yellow-accent);
            outline: none;
        }

        .form-group input.invalid:not([type="checkbox"]),
        .form-group select.invalid,
        .form-group textarea.invalid {
            border-color: #ff4444;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .checkbox-group label {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            color: #333;
        }

        .checkbox-group input[type="checkbox"] {
            display: none; /* Hide actual checkboxes */
        }

        .checkbox-group button {
            position: relative;
            outline: none;
            text-decoration: none;
            border-radius: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            text-transform: uppercase;
            height: 40px;
            padding: 0 1rem;
            opacity: 1;
            background-color: var(--green-accent);
            border: 1px solid var(--green-dark);
            transition: all 0.3s ease;
        }

        .checkbox-group button.checked {
            background-color: var(--green-dark);
            border-color: var(--yellow-accent);
        }

        .checkbox-group button span {
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.7px;
        }

        .checkbox-group button:hover {
            animation: rotate 0.7s ease-in-out both;
        }

        .checkbox-group button:hover span {
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

        .checkbox-group input[type="text"] {
            width: 200px;
            display: inline-block;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.9rem;
        }

        /* Submit Button */
        .medical-form button[type="submit"] {
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

        .medical-form button[type="submit"] span {
            color: #fff;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.7px;
        }

        .medical-form button[type="submit"]:hover {
            animation: rotate 0.7s ease-in-out both;
        }

        .medical-form button[type="submit"]:hover span {
            animation: storm 0.7s ease-in-out both;
            animation-delay: 0.06s;
        }

        .success-message {
            color: #4caf50;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1rem;
            display: none;
        }

        .server-error {
            color: #ff4444;
            font-size: 1rem;
            text-align: center;
            margin-bottom: 1rem;
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

            .medical-form h2 {
                font-size: 2rem;
            }

            .form-group h3 {
                font-size: 1.6rem;
            }

            .checkbox-group {
                flex-direction: column;
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

            .medical-form h2 {
                font-size: 1.8rem;
            }

            .form-group h3 {
                font-size: 1.4rem;
            }

            .logo img {
                height: 50px;
            }

            .medical-form button[type="submit"] {
                width: 100%;
            }

            .checkbox-group button {
                width: 100%;
                justify-content: flex-start;
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
      <li><a href="MedicalHistory.php"class="active"> Medical History</a></li>
      <li><a href="feedback.php">feedback</a></li>
      <li><a href="packages.php" >Packages</a></li>
            </ul>
        </nav>
    </header>

    <!-- Intro Section -->
    <section class="intro-section">
        <h2>Medical History Form</h2>
        <p>Provide your medical history to help us tailor your wellness journey.</p>
    </section>

    <!-- Medical History Form Section -->
    <section class="medical-form">
        <div class="form-container">
            <h2><i class="fas fa-user-md"></i> Medical History Form</h2>
            
            <div id="success-message" class="success-message" role="alert"></div>
            <div id="server-error" class="server-error" role="alert"></div>

            <form id="medical-form" method="POST" action="../backend/medical_history.php">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>">
                
                <div class="form-group">
                    <h3><i class="fas fa-user"></i> Patient Information</h3>
                    <label for="name"><i class="fas fa-signature"></i> Name *</label>
                    <input type="text" id="name" name="name" value="<?php echo $user_name; ?>" required aria-label="Name">
                    <label for="dob"><i class="fas fa-calendar"></i> DOB *</label>
                    <input type="date" id="dob" name="dob" required aria-label="Date of Birth">
                    <label for="gender"><i class="fas fa-venus-mars"></i> Gender (M/F/Other) *</label>
                    <select id="gender" name="gender" required aria-label="Gender">
                        <option value="" disabled selected>Select Gender</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <label for="address"><i class="fas fa-map-marker-alt"></i> Address</label>
                    <textarea id="address" name="address" aria-label="Address"></textarea>
                    <label for="phone"><i class="fas fa-phone"></i> Phone *</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $user_phone; ?>" required aria-label="Phone" pattern="\+?\d{10,15}">
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-heartbeat"></i> Emergency Contact</h3>
                    <label for="emergency_contact_name"><i class="fas fa-user-friends"></i> Name</label>
                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" aria-label="Emergency Contact Name">
                    <label for="emergency_contact_relationship"><i class="fas fa-link"></i> Relationship</label>
                    <input type="text" id="emergency_contact_relationship" name="emergency_contact_relationship" aria-label="Emergency Contact Relationship">
                    <label for="emergency_contact_phone"><i class="fas fa-phone"></i> Phone</label>
                    <input type="tel" id="emergency_contact_phone" name="emergency_contact_phone" aria-label="Emergency Contact Phone" pattern="\+?\d{10,15}">
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-shield-alt"></i> Insurance Information</h3>
                    <label for="insurance_provider"><i class="fas fa-hospital"></i> Insurance Provider</label>
                    <input type="text" id="insurance_provider" name="insurance_provider" aria-label="Insurance Provider">
                    <label for="policy_number"><i class="fas fa-id-card"></i> Policy Number</label>
                    <input type="text" id="policy_number" name="policy_number" aria-label="Policy Number">
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-notes-medical"></i> Personal History (check all that apply)</h3>
                    <div class="checkbox-group">
                        <?php
                        $personal_history_options = [
                            'Allergies' => 'Allergies (Drug, Food, Environmental)',
                            'Anemia' => 'Anemia',
                            'Arthritis' => 'Arthritis',
                            'Asthma' => 'Asthma',
                            'Blood Transfusion' => 'Blood Transfusion',
                            'Cancer' => 'Cancer (Specify)',
                            'Congestive Heart Failure' => 'Congestive Heart Failure',
                            'COPD/Emphysema' => 'COPD / Emphysema',
                            'Depression' => 'Depression',
                            'Diabetes (Type 1 / Type 2)' => 'Diabetes (Type 1 / Type 2)',
                            'Epilepsy/Seizures' => 'Epilepsy / Seizures',
                            'GERD (Acid Reflux)' => 'GERD (Acid Reflux)',
                            'Glaucoma' => 'Glaucoma',
                            'Gout' => 'Gout',
                            'Heart Attack/Heart Disease' => 'Heart Attack / Heart Disease',
                            'High Blood Pressure' => 'High Blood Pressure (Hypertension)',
                            'HIV/AIDS' => 'HIV / AIDS',
                            'Kidney Disease/Kidney Stones' => 'Kidney Disease / Kidney Stones',
                            'Liver Disease/Hepatitis' => 'Liver Disease / Hepatitis',
                            'Migraines' => 'Migraines',
                            'Osteoporosis' => 'Osteoporosis',
                            'Stroke' => 'Stroke',
                            'Substance Abuse' => 'Substance Abuse (Alcohol / Drugs)',
                            'Thyroid Disease' => 'Thyroid Disease (Hypo / Hyper)',
                            'Tuberculosis' => 'Tuberculosis',
                            'Ulcers' => 'Ulcers'
                        ];
                        foreach ($personal_history_options as $value => $label) {
                            echo "<label>
                                    <input type='checkbox' name='personal_history[]' value='$value' class='hidden-checkbox'>
                                    <button type='button' role='checkbox' aria-checked='false' aria-label='$label'>
                                        <span>$label</span>
                                    </button>
                                  </label>";
                        }
                        ?>
                        <label for="other_medical_issues"><i class="fas fa-plus-circle"></i> Other Medical Issues</label>
                        <textarea id="other_medical_issues" name="other_medical_issues" aria-label="Other Medical Issues"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-pills"></i> Treatments/Medications</h3>
                    <label for="treatments_medications"><i class="fas fa-prescription"></i> Name(s), Dosage(s), Frequency, Purpose, Note(s)</label>
                    <textarea id="treatments_medications" name="treatments_medications" aria-label="Treatments/Medications"></textarea>
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-procedures"></i> Surgeries/Procedures (with dates)</h3>
                    <label for="surgeries_procedures"><i class="fas fa-calendar-alt"></i> Details</label>
                    <textarea id="surgeries_procedures" name="surgeries_procedures" aria-label="Surgeries/Procedures"></textarea>
                    <label for="allergies"><i class="fas fa-allergies"></i> Allergies</label>
                    <textarea id="allergies" name="allergies" aria-label="Allergies"></textarea>
                </div>

                <div class="form-group">
                    <h3><i class="fas fa-users"></i> Family History (check all that apply)</h3>
                    <div class="checkbox-group">
                        <?php
                        $family_history_options = [
                            'No known family history' => 'No known family history of medical conditions',
                            'Cancer' => 'Cancer',
                            'Diabetes' => 'Diabetes',
                            'Heart Disease' => 'Heart Disease',
                            'High Blood Pressure' => 'High Blood Pressure',
                            'High Cholesterol' => 'High Cholesterol',
                            'Kidney Disease' => 'Kidney Disease',
                            'Mental Health Conditions' => 'Mental Health Conditions (Depression, Anxiety, etc.)',
                            'Stroke' => 'Stroke',
                            'Thyroid Disease' => 'Thyroid Disease'
                        ];
                        foreach ($family_history_options as $value => $label) {
                            echo "<label>
                                    <input type='checkbox' name='family_history[]' value='$value' class='hidden-checkbox'>
                                    <button type='button' role='checkbox' aria-checked='false' aria-label='$label'>
                                        <span>$label</span>
                                    </button>
                                  </label>";
                        }
                        ?>
                        <label>
                            <input type="checkbox" name="family_history[]" value="Other" class="hidden-checkbox">
                            <button type="button" role="checkbox" aria-checked="false" aria-label="Other family history condition">
                                <span>Other</span>
                            </button>
                            <input type="text" name="family_history_other" placeholder="Specify other condition" aria-label="Specify other family history condition">
                        </label>
                    </div>
                </div>

                <button type="submit" id="submit-button"><span>Submit</span></button>
            </form>
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
        // Toggle Button Checkbox Behavior
        document.querySelectorAll('.checkbox-group button').forEach(button => {
            button.addEventListener('click', function() {
                const checkbox = this.previousElementSibling;
                const isChecked = checkbox.checked;
                checkbox.checked = !isChecked;
                this.setAttribute('aria-checked', !isChecked);
                this.classList.toggle('checked', !isChecked);
            });

            // Keyboard accessibility
            button.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });

        // Medical History Form Validation and AJAX Submission
        document.getElementById('medical-form').addEventListener('submit', async function(event) {
            event.preventDefault();
            const submitButton = document.getElementById('submit-button');
            submitButton.disabled = true;
            submitButton.querySelector('span').textContent = 'Submitting...';

            // Reset messages
            const successMessage = document.getElementById('success-message');
            const serverError = document.getElementById('server-error');
            successMessage.style.display = 'none';
            serverError.style.display = 'none';

            // Client-side validation
            const name = document.getElementById('name').value.trim();
            const dob = document.getElementById('dob').value;
            const gender = document.getElementById('gender').value;
            const phone = document.getElementById('phone').value.trim();
            const emergencyContactPhone = document.getElementById('emergency_contact_phone').value.trim();

            if (!name || !dob || !gender || !phone || !/^\+?\d{10,15}$/.test(phone)) {
                serverError.textContent = 'Please fill all required fields correctly.';
                serverError.style.display = 'block';
                submitButton.disabled = false;
                submitButton.querySelector('span').textContent = 'Submit';
                return;
            }

            if (emergencyContactPhone && !/^\+?\d{10,15}$/.test(emergencyContactPhone)) {
                serverError.textContent = 'Invalid emergency contact phone number format.';
                serverError.style.display = 'block';
                submitButton.disabled = false;
                submitButton.querySelector('span').textContent = 'Submit';
                return;
            }

            const formData = new FormData(this);
            try {
                const response = await fetch('../backend/medical_history.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    successMessage.textContent = result.message;
                    successMessage.style.display = 'block';
                    document.getElementById('medical-form').reset();
                    // Reset button states
                    document.querySelectorAll('.checkbox-group button').forEach(button => {
                        button.classList.remove('checked');
                        button.setAttribute('aria-checked', 'false');
                    });
                } else {
                    serverError.textContent = result.message;
                    serverError.style.display = 'block';
                }
            } catch (error) {
                serverError.textContent = 'An error occurred. Please try again.';
                serverError.style.display = 'block';
            } finally {
                submitButton.disabled = false;
                submitButton.querySelector('span').textContent = 'Submit';
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
<?php
$conn->close();
?>