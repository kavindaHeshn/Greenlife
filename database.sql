CREATE DATABASE IF NOT EXISTS GreenLife;
USE GreenLife;

-- Table for contact inquiries
CREATE TABLE IF NOT EXISTS inquiries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for user accounts
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    role ENUM('customer', 'staff', 'admin') DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for doctor contact inquiries
CREATE TABLE IF NOT EXISTS doctor_contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    answer TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for customer feedback
CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    feedback TEXT NOT NULL,
    rating INT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for bookings
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    package_name VARCHAR(100) NOT NULL,
    preferred_date DATE NOT NULL,
    preferred_time TIME NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table for medical history
CREATE TABLE IF NOT EXISTS medical_histories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('M', 'F', 'Other') NOT NULL,
    address TEXT,
    phone VARCHAR(20) NOT NULL,
    emergency_contact_name VARCHAR(255),
    emergency_contact_relationship VARCHAR(100),
    emergency_contact_phone VARCHAR(20),
    insurance_provider VARCHAR(255),
    policy_number VARCHAR(100),
    personal_history TEXT,
    other_medical_issues TEXT,
    treatments_medications TEXT,
    surgeries_procedures TEXT,
    allergies TEXT,
    family_history TEXT,
    family_history_other TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;