<?php

namespace app\Middleware;

class SessionAuthMiddleware
{
    // Constructor to start the session if it is not already started
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Method to destroy the session and clear session data
    public function destroySession()
    {
        // Destroy session
        session_destroy();
    }

    // Method to handle authentication and session timeout
    public function handle($request_uri)
    {
        // Define protected routes
        $protectedRoutes = ['/admin', '/employee']; // Example protected routes

        // Check if user is authenticated
        if (!isset($_SESSION["auth"]) && !in_array($request_uri, $protectedRoutes)) {
            // User is not authenticated
            if ($request_uri !== '/login') {
                $_SESSION['message'] = "Unauthenticated! Please log in!";
                $_SESSION['message_code'] = 'error';
                header("Location: /login", true, 302);
                exit();
            }
        }

        // Define session timeout duration (in seconds)
        $timeout_duration =  30 * 60; 
        if (isset($_SESSION['session_start_time'])) {
            $elapsed_time = time() - $_SESSION['session_start_time'];
            if ($elapsed_time > $timeout_duration) {
                $this->destroySession();
                $_SESSION['session_expired'] = true;
                $_SESSION['message'] = "Session expired! Please log in again.";
                $_SESSION['message_code'] = 'error';
                header("Location: /login", true, 302);
                exit();
            }
        }

        return true;
    }
}
