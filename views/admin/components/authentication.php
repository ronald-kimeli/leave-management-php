<?php
// Start session if not already started
session_status() === PHP_SESSION_ACTIVE ?: session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Login to access dashboard";
    header("Location: /login");
    exit;
}

if ($_SESSION['auth_role'] === 'employee') {
    $_SESSION['message'] = "Already logged in";
    header("Location: /employee/dashboard");
    exit;
}

if(isset($viewResult)) $Title = $viewResult->getHeaderTitle() ? $viewResult->getHeaderTitle()  : '';

