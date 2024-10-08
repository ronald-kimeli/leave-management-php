<?php
// Check
include 'authentication.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="author" content="" />
    <title>
        <?= isset($Title) ? htmlspecialchars($Title) : 'Default Title' ?>
    </title>
    <meta name="description"
        content="<?= isset($description) ? htmlspecialchars($description) : 'Default Description' ?>">

  <!-- FAVICON -->
  <link rel="apple-touch-icon" sizes="180x180" href="/views/assets/frontend/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/views/assets/frontend/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/views/assets/frontend/favicon-16x16.png">

  <link rel="mask-icon" href="/views/assets/frontend/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  <!-- STYLESHEETS -->
  <link rel="stylesheet" href="/views/assets/frontend/css/style.css">
  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- end previous application navbar.php -->
  <link rel="stylesheet" href="/views/assets/frontend/css/bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Template Main CSS File -->
  <link rel="stylesheet" href="/views/assets/frontend/css/custom.css">
  <link href="/views/assets/css/sb-admin-2.css" rel="stylesheet">
</head>

<body>
<main id="body">

