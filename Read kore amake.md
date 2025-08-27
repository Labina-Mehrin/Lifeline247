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
