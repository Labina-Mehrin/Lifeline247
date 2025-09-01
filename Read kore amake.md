# LifeLine for the Missing

A centralized platform to help families, rescue teams, hospitals, and authorities find and support missing persons during disasters and emergencies.






*********
query lekha hoisey for :

-> user 

MariaDB [lmr]> CREATE TABLE users (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     name VARCHAR(100) NOT NULL,
    ->     email VARCHAR(100) NOT NULL UNIQUE,
    ->     password VARCHAR(255) NOT NULL,
    ->     role VARCHAR(50) NOT NULL,
    ->     created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    -> );


-> register missing  

MariaDB [lmr]> CREATE TABLE missing_persons (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     name VARCHAR(100) NOT NULL,
    ->     photo VARCHAR(255),
    ->     location VARCHAR(255) NOT NULL,
    ->     contact VARCHAR(100) NOT NULL,
    ->     features TEXT NOT NULL,
    ->     reported_by INT NOT NULL,
    ->     reported_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    ->     FOREIGN KEY (reported_by) REFERENCES users(id)
    -> );


ekhan theke egula sql query update korba lodu



    CREATE TABLE blood_donors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    name VARCHAR(100),
    blood_group VARCHAR(10),
    location VARCHAR(100),
    contact VARCHAR(50),
    registered_at DATETIME
);

CREATE TABLE blood_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_id INT,
    blood_group VARCHAR(10),
    type VARCHAR(50),
    location VARCHAR(100),
    details TEXT,
    requested_at DATETIME
);



CREATE TABLE relief_needs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    need_type VARCHAR(50),
    location VARCHAR(100),
    details TEXT,
    contact VARCHAR(50),
    requested_at DATETIME
);

CREATE TABLE relief_donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    donation_type VARCHAR(50),
    location VARCHAR(100),
    details TEXT,
    contact VARCHAR(50),
    donated_at DATETIME
);