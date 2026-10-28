<?php
/** @var \app\Responses\View|null $viewResult Provided by the router. */
$viewResult ??= null;

// Start session if not already started
session_status() === PHP_SESSION_ACTIVE ?: session_start();

// Signed-in users have no business on the public pages: send them to their own dashboard.
if (isset($_SESSION['auth_role']) && in_array($_SESSION['auth_role'], ['admin', 'employee'], true)) {
    $role = $_SESSION['auth_role'];
    $_SESSION['message'] = "Logged in as {$role}";
    header("Location: /{$role}/dashboard");
    exit;
}

$Title = $viewResult?->getHeaderTitle() ?: '';
