<?php

namespace app\Middleware;

class SessionAuthMiddleware
{
    /** Seconds of inactivity after which a signed-in user is logged out (also read by public/assets/js/autologout.js). */
    public const IDLE_TIMEOUT = 15 * 60;

    // Constructor to start the session if it is not already started
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function destroySession()
    {
        session_destroy();
    }

    public function handle($request_uri)
    {
        // Define protected routes
        $protectedRoutes = ['/admin', '/employee'];

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

        // Idle timeout: any authenticated request pushes the deadline forward.
        if (isset($_SESSION['auth'])) {
            $lastActivity = $_SESSION['last_activity'] ?? $_SESSION['session_start_time'] ?? time();
            if (time() - $lastActivity > self::IDLE_TIMEOUT) {
                $this->destroySession();
                session_start();
                $_SESSION['message'] = "Session expired! Please log in again.";
                $_SESSION['message_code'] = 'error';
                header("Location: /login", true, 302);
                exit();
            }
            $_SESSION['last_activity'] = time();
        }

        return true;
    }
}
