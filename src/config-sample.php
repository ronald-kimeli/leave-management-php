<?php
$servername = "servername";
$username = "username";
$password = "password";
$database = "leave_management_system";

$dsn = "mysql:host=$servername;dbname={$database};charset=utf8mb4";

$options = [
    PDO::ATTR_EMULATE_PREPARES => false,
        // Disable emulation mode for "real" prepared statements
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Disable errors in the form of exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    // Make the default fetch be an associative array
];

try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
    require_once __DIR__ . "/../errors/dberror.php";
    die();
}