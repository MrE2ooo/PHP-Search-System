<?php
// Database connection details
$host = "localhost"; // XAMPP default host
$dbname = "myfirstdatabase"; // Your database name
$username = "root"; // XAMPP default username
$password = ""; // XAMPP default password (empty)

// Connect to the database using PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>