<?php
require __DIR__ . "/includes/header.php";

if ($request_resourse && $Refreshed) {
    switch ($request_resourse) {
        case (file_exists($request_resourse)):
            require_once $request_resourse;
            break;

        case (!file_exists($request_resourse)):
            // http_response_code(404);
            require_once "404.php";
            break;

        default:
            require_once 'dashboard.php';
            break;
    }
}

require __DIR__ . "/includes/scripts.php";
