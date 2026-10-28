<?php
/** @var \app\Responses\View|null $viewResult View handed over by the router; absent on direct includes. */
$viewResult ??= null;

// Start session if not already started
session_status() === PHP_SESSION_ACTIVE ?: session_start();


if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Login to access dashboard";
    header("Location: /login");
    exit;
}

// Panel being rendered ('admin' or 'employee') and the signed-in user's role.
$panel = $viewResult !== null ? $viewResult->getViewPath()->dir : $_SESSION['auth_role'];
$role = $_SESSION['auth_role'];

// Employees are gated out of the admin panel (and admins out of the employee one).
if ($role !== $panel) {
    $_SESSION['message'] = "Already logged in";
    header("Location: /{$role}/dashboard");
    exit;
}

$Title = $viewResult?->getHeaderTitle() ?: '';
