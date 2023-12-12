<?php
require __DIR__ . '/../../src/config.php';
require __DIR__ . '/../../src/functions.php';

$request_uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$request_method = $_SERVER['REQUEST_METHOD'];

if (isset($_SESSION['auth'])) {
    if ($_SESSION['auth_role'] === "0") {
        $_SESSION['message'] = "Logged in already!";
        header("Location: /employee/index.php ");
        exit(0);
    } elseif ($_SESSION['auth_role'] === "1") {
        $_SESSION['message'] = "Logged in already!";
        header("Location: /admin/dashboard");
        exit(0);
    }
}else {
        $request_resourse = $request_uri. ".php";
            if ($request_method == "GET") {
                $request_resourse;
            } elseif ($request_method == "POST") {
                include "../{$request_uri}.php";
            } elseif ($request_method == "PUT") {
                include "../{$request_uri}.php";
            } elseif ($request_method == "DELETE") {
                include "../{$request_uri}.php";
            }
    }

