<?php

namespace app\controllers;


class Controller
{
    public function __construct()
    {
        // Start the session if not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSessionVariable($key, $value)
    {
        // Set session variable
        $_SESSION[$key] = $value;
    }

    public function getSessionVariable($key)
    {
        // Get session variable
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function destroySession()
    {
        // Destroy session
        session_destroy();
    }

    public function isLoggedIn()
    {
        // Check if user is logged in
        return isset($_SESSION['user_id']);
    }

    public function addMessage($type, $message)
    {
        // Add a message to be displayed in the view
        $_SESSION['messages'][] = ['type' => $type, 'message' => $message];
    }

    public function getMessages()
    {
        // Get messages to be displayed in the view
        $messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : [];
        unset($_SESSION['messages']); // Clear messages after fetching
        return $messages;
    }

}


// public function someAction()
// {
//     // Check if user is logged in
//     if ($this->isLoggedIn()) {
//         // User is logged in
//     } else {
//         // User is not logged in
//     }

//     // Add a success message
//     $this->addMessage('success', 'User registered successfully.');

//     // Get messages to display in the view
//     $messages = $this->getMessages();
// }