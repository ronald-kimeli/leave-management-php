<?php
// session_start();
require __DIR__ . '/../../src/config.php';
require __DIR__ . '/../../src/functions.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (!isset($_SESSION['auth'])) {
    $_SESSION['message'] = "Login to access dashboard";
    header("Location: /login");
    exit(0);
} else {
    if ($_SESSION['auth_role'] === 0) {
        $_SESSION['message'] = "Already logged in";
        header("Location: /employee/dashboard");
        exit(0);
    } else {
        $request_resourse = str_replace("/admin/", "/", $request_uri) . ".php";
        if (str_contains($request_uri, '/admin/') && $request_resourse != "./.php") {
            $root = 'admin';
            $request_resourse = $root.$request_resourse;
            if ($request_method == "GET") {
                $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
                if ($pageWasRefreshed) {
                    $Refreshed = true;
                    // Do something because page was refreshed
                    $request_resourse;
                } else {
                    $Refreshed = false;
                    switch ($request_resourse) {
                        case (file_exists($request_resourse)):
                            require_once $request_resourse;
                            break;

                        case (!file_exists($request_resourse)):
                            // http_response_code(404);
                            require_once "admin/404.php";
                            break;

                        default:
                            require_once 'admin/dashboard.php';
                            break;
                    }
                }
            } elseif ($request_method == "POST") {
                include $request_resourse;
            } elseif ($request_method == "PUT") {
                include $request_resourse;
            } elseif ($request_method == "DELETE") {
                include $request_resourse;
            }
        } else {
            $_SESSION['message'] = "Already logged in";
            header("Location: /admin/dashboard");
            exit(0);
        }
    }
}
