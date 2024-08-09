<?php
// Start session if not already started
session_status() === PHP_SESSION_ACTIVE ?: session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

$request_method = $_SERVER['REQUEST_METHOD'];

if (!isset($_SESSION['auth']) && !$request_uri === '/login') {
    $_SESSION['message'] = "Login to access dashboard";
    header("Location: /login");
    exit;
} 

if (isset($_SESSION['auth_role'])) {
    // Redirect admin to admin dashboard
    if ($_SESSION['auth_role'] === 'admin' && !$request_uri !== '/admin/dashboard') {
        $_SESSION['message'] = "Logged in as admin";
        header("Location: /admin/dashboard");
        exit;
    }

    // Redirect employee to employee dashboard
    if ($_SESSION['auth_role'] === 'employee' && !$request_uri !== '/employee/dashboard') {
        $_SESSION['message'] = "Logged in as employee";
        header("Location: /employee/dashboard");
        exit;
    }
}

if(isset($viewResult)) $Title = $viewResult->getHeaderTitle() ? $viewResult->getHeaderTitle()  : '';


