# LifeLine for the Missing

A centralized platform to help families, rescue teams, hospitals, and authorities find and support missing persons during disasters and emergencies.






*********
query lekha hoisey for :



-Missing person
CREATE TABLE missing_persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT,
    last_seen_location VARCHAR(255),
    last_seen_datetime DATETIME,
    photos TEXT, -- JSON array of image URLs/paths
    status VARCHAR(20) DEFAULT 'PENDING',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--admin login
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Store hashed passwords
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--donation
CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donation_type VARCHAR(50),         -- e.g. 'Funds for Relief', 'Emergency Fund', etc.
    amount DECIMAL(10,2),              -- For monetary donations
    payment_method VARCHAR(50),        -- e.g. 'Credit/Debit Card', 'PayPal', etc.
    donor_name VARCHAR(100),
    donor_email VARCHAR(100),
    donor_phone VARCHAR(20),
    items VARCHAR(255),                -- For item-based donations (comma-separated or JSON)
    quantity INT,
    pickup_location VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--hospitals and shelters
CREATE TABLE hospitals_shelters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    type VARCHAR(50),                -- 'Hospital' or 'Shelter'
    address VARCHAR(255),
    contact_phone VARCHAR(30),
    contact_email VARCHAR(100),
    capacity INT,                    -- Number of beds/people supported
    description TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
-list_blood
CREATE TABLE blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    requester_name VARCHAR(100) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    quantity INT,                        -- Number of units needed
    hospital VARCHAR(150),
    contact_phone VARCHAR(30),
    contact_email VARCHAR(100),
    needed_by DATE,
    status VARCHAR(20) DEFAULT 'PENDING', -- e.g. 'PENDING', 'FULFILLED'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--register_blood
CREATE TABLE blood_donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(100) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    age INT,
    contact_phone VARCHAR(30),
    contact_email VARCHAR(100),
    address VARCHAR(255),
    last_donation_date DATE,
    available BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--register missing
CREATE TABLE missing_persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT,
    gender VARCHAR(10),
    last_seen_location VARCHAR(255),
    last_seen_datetime DATETIME,
    description TEXT,
    photos TEXT, -- JSON array or comma-separated image paths
    reporter_name VARCHAR(100),
    reporter_contact VARCHAR(100),
    status VARCHAR(20) DEFAULT 'PENDING', -- e.g. 'PENDING', 'APPROVED', 'FOUND'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--report missing
CREATE TABLE missing_persons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT,
    gender VARCHAR(10),
    last_seen_location VARCHAR(255),
    last_seen_datetime DATETIME,
    description TEXT,
    photos TEXT, -- JSON array or comma-separated image paths
    reporter_name VARCHAR(100),
    reporter_contact VARCHAR(100),
    status VARCHAR(20) DEFAULT 'PENDING', -- e.g. 'PENDING', 'APPROVED', 'FOUND'
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
--report sighting
CREATE TABLE sightings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    missing_person_id INT,                  -- Reference to missing_persons table
    sighting_location VARCHAR(255),
    sighting_datetime DATETIME,
    description TEXT,
    reporter_name VARCHAR(100),
    reporter_contact VARCHAR(100),
    photo TEXT,                             -- Optional: image path or URL
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (missing_person_id) REFERENCES missing_persons(id)
);