<?php
session_start();
// Get the requested URL
$request_uri = parse_url($_SERVER['REQUEST_URI'])['path'];

/**
 * Request method
 */
$request_method = $_SERVER['REQUEST_METHOD'];

if(isset($_SESSION["auth"])) {
  if($_SESSION["auth_role"] === 1) {
    // $_SESSION['message'] = "Logged in already!";
    // header("Location: /admin/dashboard");
    $route_file = __DIR__.'/admin/'.'index.php';
    if(file_exists($route_file)) {
      require $route_file;
    }
    exit();
  } else {
    // $_SESSION['message'] = "Logged in already!";
    // header("Location: /employee/dashboard");
    $route_file = __DIR__.'/employee/'.'index.php';
    if(file_exists($route_file)) {
      require $route_file;
    }
    exit();
  }
}

$routes = [
  '' => 'index.php',
  '/' => 'index.php',
  '404'=> '404.php',
  '/register' => 'register.php',
  '/login' => 'login.php',
  '/test/testing' => 'testing/views/index.php',
  '/signin' => 'signin.php',
  '/apply-leave' => 'apply-leave.php',
  '/about' => 'about.php',
  '/allcode' => 'allcode.php',
  '/leavestatus' => 'leavestatus.php',
  '/forgot/password' => 'forgot-password.php',
  '/reset-password' => 'reset-password.php',
  '/verify_email' => 'verify_email.php',
  '/reset_password' => 'reset_password.php'
];

if(array_key_exists($request_uri, $routes)) {
  if($request_method === 'GET') {
    $route_file = __DIR__.'/frontend/views/'.$routes[$request_uri];
    if(file_exists($route_file)) {
      require $route_file;
    }
  } elseif($request_method === 'POST') {
    $route_file = __DIR__.'/frontend/controller/'.$request_uri.'.php';
    if(file_exists($route_file)) {
      require $route_file;
      exit;
    }
  }
} else {
  // http_response_code(404);
  $error = 404;
  $route_file = __DIR__.'/frontend/views/'.$routes[$error];
  require $route_file;
  exit;
}

function ddd($data) {
  echo "<pre>";
  var_dump($data);
  echo "</pre>";
  die();
}
