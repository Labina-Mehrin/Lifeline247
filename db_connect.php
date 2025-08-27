<?php
$host = 'localhost';
$user = 'root';
$password = ''; // Default XAMPP password is empty
$dbname = 'lmr'; //test case site name 

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// You can now use $conn for your queries
//echo "Database connected successfully.";
?>





