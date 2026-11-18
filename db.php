
<?php

// Database connection settings

$host = "localhost";
$username = "root";
$password = "";
$database = "smashpoint_db";

// Connect to MySQL

$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

// Check database connection

if ($conn->connect_error) {

    die("Database connection failed: " .
        $conn->connect_error);

}

// Set character encoding

$conn->set_charset("utf8mb4");

?>
