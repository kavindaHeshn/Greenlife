<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>GreenLife Admin Dashboard</title>
  <style>
    /* Smooth transition for dark/light mode */
    body {
      background-color: #f3f4f6; /* Equivalent to Tailwind bg-gray-100 */
      color: #374151; /* Equivalent to Tailwind text-gray-700 */
      transition: background-color 0.3s ease, color 0.3s ease;
    }
    body.dark {
      background-color: #111827; /* Equivalent to Tailwind dark:bg-gray-900 */
      color: #d1d5db; /* Equivalent to Tailwind dark:text-gray-300 */
    }

    /* Sidebar */
    .sidebar {
      width: 16rem; /* Equivalent to Tailwind w-64 */
      background: linear-gradient(180deg, #15803d, #16a34a); /* Gradient green-800 to green-600 */
      color: #ffffff; /* White text */
      padding: 1rem; /* Equivalent to Tailwind p-4 */
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .dark .sidebar {
      background: linear-gradient(180deg, #000000, #1f2937); /* Gradient black to gray-800 in dark mode */
    }

    /* Logo styling */
    .logo {
      display: flex;
      justify-content: center;
      margin-bottom: 1.5rem;
    }
    .logo img {
      width: 100%;
      max-width: 8rem;
      height: auto;
      border-radius: 0.5rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }
    .dark .logo img {
      box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
    }

    /* Sidebar links */
    .nav-link {
      display: block;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: background-color 0.3s ease, transform 0.3s ease;
      transform: translateX(-20px);
      opacity: 0;
      animation: slideIn 0.5s ease forwards;
      animation-delay: calc(0.1s * var(--index));
      color: #ffffff;
      position: relative; /* For underline animation */
      text-decoration: none;
    }
    .nav-link:hover {
      background-color: #1f2937; /* Gray-800 for contrast */
      transform: scale(1.03); /* Slight scale on hover */
    }
    .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 1rem;
      background-color: #86efac; /* Green-400 for underline */
      transition: width 0.3s ease;
    }
    .nav-link:hover::after {
      width: calc(100% - 2rem); /* Underline expands on hover */
    }
    .nav-link.active {
      background-color: #16a34a; /* Green-600 for active link */
      font-weight: 600;
    }

    /* Logout button */
    .btn-logout {
      width: 100%;
      background-color: #ad870c; /* Original red-600 */
      color: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border: none;
      cursor: pointer;
    }
    .btn-logout:hover {
      background-color: #b91c1c; /* Original red-700 */
      transform: scale(1.05);
    }

    /* Dark mode toggle button */
    .btn-dark {
      background-color: #1f2937; /* Gray-800 */
      color: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      border: none;
      cursor: pointer;
    }
    .btn-dark:hover {
      background-color: #15803d; /* Green-700 */
      transform: scale(1.05);
    }

    /* Language toggle button */
    .btn-language {
      background-color: #1f2937; /* Gray-800 */
      color: #ffffff;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      font-weight: 600;
      transition: background-color 0.3s ease, transform 0.2s ease;
      border: none;
      cursor: pointer;
      margin-bottom: 1rem;
      text-align: center;
    }
    .btn-language:hover {
      background-color: #15803d; /* Green-700 */
      transform: scale(1.05);
    }

    /* Main content */
    .main-content {
      flex: 1;
      padding: 2rem;
      animation: fadeIn 0.8s ease forwards;
      opacity: 0;
    }

    /* Header */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }
    .header h2 {
      font-size: 1.875rem;
      font-weight: 700;
      color: #15803d; /* Green-800 */
    }
    .dark .header h2 {
      color: #86efac; /* Green-400 */
    }
    .header p {
      color: #4b5563; /* Gray-600 */
    }
    .dark .header p {
      color: #d1d5db; /* Gray-300 */
    }

    /* Flex container for layout */
    .flex-container {
      display: flex;
      min-height: 100vh;
    }

    /* Slide-in animation for sidebar links */
    @keyframes slideIn {
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    /* Fade-in animation for main content and logo */
    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }

    /* Ensure smooth transitions for all elements */
    * {
      transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
    }
  </style>
</head>
<body>
  <div class="flex-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <div class="logo">
          <img src="../photos/logo.jpg" alt="GreenLife Wellness Center Logo">
        </div>
        <h1 class="text-2xl font-bold mb-6 text-center">🌿 GreenLife</h1>
        <button id="languageToggle" class="btn-language">Switch to Sinhala</button>
        <nav>
          <ul>
           <li><a href="contactus.php" class="nav-link">Manage contact us</a></li>
            <li><a href="bookings.php" class="nav-link active">Manage Bookings</a></li>
            <li><a href="user.php" class="nav-link">Manage Users</a></li>
            <li><a href="feedback.php" class="nav-link">Manage Feedback</a></li>
            
          </ul>
        </nav>
      </div>
      <!-- Logout Button -->
      <div class="mt-6">
        <button id="logoutBtn" class="btn-logout">Logout</button>
      </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <!-- Header -->
      <div class="header">
        <div>
          <h2>Admin Dashboard</h2>
          <p>Manage all aspects of GreenLife operations.</p>
        </div>
        <!-- Dark Mode Toggle -->
        <button id="darkToggle" class="btn-dark">
          <span id="darkToggleIcon">🌙</span>
          <span id="darkToggleText">Dark Mode</span>
        </button>
      </div>
    </div>
  </div>

  <script>
    // Translation data
    const translations = {
      en: {
        inquiries: 'Manage Inquiries',
        users: 'Manage Users',
        'doctor-contacts': 'Manage Doctor Contacts',
        feedback: 'Manage Feedback',
        bookings: 'Manage Bookings',
        'medical-histories': 'Manage Medical Histories',
        languageToggle: 'Switch to Sinhala'
      },
      si: {
        inquiries: 'පරීක්ෂණ කළමනාකරණය',
        users: 'පරිශීලකයින් කළමනාකරණය',
        'doctor-contacts': 'වෛද්‍ය සම්බන්ධතා කළමනාකරණය',
        feedback: 'ප්‍රතිපෝෂණ කළමනාකරණය',
        bookings: 'වෙන්කිරීම් කළමනාකරණය',
        'medical-histories': 'වෛද්‍ය ඉතිහාසය කළමනාකරණය',
        languageToggle: 'Switch to English'
      }
    };

    // Initialize language from localStorage or default to English
    let currentLanguage = localStorage.getItem('language') || 'en';
    updateLanguage(currentLanguage);

    // Language toggle
    document.getElementById('languageToggle').addEventListener('click', () => {
      currentLanguage = currentLanguage === 'en' ? 'si' : 'en';
      localStorage.setItem('language', currentLanguage);
      updateLanguage(currentLanguage);
    });

    // Update navigation link text based on language
    function updateLanguage(lang) {
      document.querySelectorAll('.nav-link').forEach(link => {
        const key = link.getAttribute('data-key');
        link.textContent = translations[lang][key];
      });
      document.getElementById('languageToggle').textContent = translations[lang].languageToggle;
    }

    // Check localStorage for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
      document.documentElement.classList.add('dark');
      document.getElementById('darkToggleIcon').textContent = '☀️';
      document.getElementById('darkToggleText').textContent = 'Light Mode';
    }

    // Dark mode toggle
    document.getElementById('darkToggle').addEventListener('click', () => {
      document.documentElement.classList.toggle('dark');
      const isDark = document.documentElement.classList.contains('dark');
      localStorage.setItem('theme', isDark ? 'dark' : 'light');
      document.getElementById('darkToggleIcon').textContent = isDark ? '☀️' : '🌙';
      document.getElementById('darkToggleText').textContent = isDark ? 'Light Mode' : 'Dark Mode';
    });

    // Logout confirmation
    document.getElementById('logoutBtn').addEventListener('click', () => {
      if (confirm('Are you sure you want to logout?')) {
        window.location.href = 'login.html';
      }
    });

    // Active link highlighting
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', () => {
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
      });
    });
  </script>
</body>
</html>