<?php
/** @var \app\Responses\View|null $viewResult */
require __DIR__ . '/authentication.php'; // sets $viewResult, $Title and $role
/** @var string $role */
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="author" content="" />
  <meta name="session-idle-timeout" content="<?= \app\Middleware\SessionAuthMiddleware::IDLE_TIMEOUT ?>">
  <meta name="session-role" content="<?= htmlspecialchars($role) ?>">
  <script src="/assets/js/theme.js"></script>
  <title>
    <?= isset($Title) ? htmlspecialchars($Title) : 'Leave management' ?>
  </title>
  <meta name="description"
    content="<?= isset($description) ? htmlspecialchars($description) : 'Default Description' ?>">
  <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/frontend/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/frontend/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/assets/frontend/favicon-16x16.png">

  <link rel="mask-icon" href="/assets/frontend/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#0d6efd">
  <!-- FAVICON -->

  <link href="/assets/css/styles.css" rel="stylesheet">
  <link href="/assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="/assets/css/dashboard.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="/assets/css/theme.css" rel="stylesheet">
</head>

<body class="sb-nav-fixed">
  <?php require __DIR__ . '/navbar-top.php'; ?>

  <div id="layoutSidenav">
    <?php require __DIR__ . '/sidebar.php'; ?>

    <div id="layoutSidenav_content">
      <main id="main">