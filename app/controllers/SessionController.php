<?php

namespace app\controllers;

class SessionController extends Controller
{
    // Reaching this action already refreshed the idle timer in SessionAuthMiddleware.
    public function ping()
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'alive']);
        exit;
    }
}
