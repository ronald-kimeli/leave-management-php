<?php
include 'authentication.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="author" content="" />
  <title>
    <?= isset($Title) ? htmlspecialchars($Title) : 'Leave management' ?>
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
  <!-- FAVICON -->

  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="/views/assets/css/styles.css" rel="stylesheet">
  <link href="/views/assets/css/sb-admin-2.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <style>

    .table {
      width: 100%;
      margin-bottom: 20px;
      border-collapse: collapse;
    }

    .table th,
    .table td {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    .table th {
      background-color: #f2f2f2;
    }

    .pagination {
      margin-top: 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .pagination p {
      margin: 0;
    }

    .pagination .pagination-links {
      text-align: right;
    }

    .pagination button {
      margin-left: 4px;
      background-color: #f2f2f2;
      border: 1px solid #ddd;
      padding: 8px 12px;
      cursor: pointer;
      font-size: 0.875rem;
    }

    .pagination button.active {
      background-color: #007bff;
      color: #fff;
      border: 1px solid #007bff;
    }


    .search-container {
      display: flex !important;
      justify-content: space-between !important;
      align-items: center !important;
      margin-bottom: 10px !important;
      gap: 1rem !important;
    }

    .search-container .left {
      display: flex !important;
      align-items: center !important;
    }

    .search-container .left input[type=text] {
      padding: 8px !important;
      width: 100% !important;
      max-width: 300px !important;
      border: 1px solid #ccc !important;
      border-radius: 4px !important;
    }

    .search-container .left button {
      padding: 8px 12px !important;
      background-color: #007bff !important;
      color: #fff !important;
      border: none !important;
      border-radius: 4px !important;
      cursor: pointer !important;
      margin-left: 5px !important;
    }

    .loading-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(255, 255, 255, 0.7);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
      border-radius: 10px;
    }

    .loading-overlay .spinner {
      border: 4px dotted rgba(0, 0, 0, 0.3);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
    }

    .action-icons {
      text-align: center;
    }

    .dropdown-menu {
      position: absolute;
      right: 0;
      width: max-content;
      max-width: 300px;
      overflow: hidden;
      z-index: 1000;
    }

    @media (max-width: 768px) {

      .table th,
      .table td {
        padding: 6px;
      }

      .dropdown-menu {
        max-width: 100%;
        right: auto;
        left: 0;
      }

      .pagination {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .pagination .pagination-links {
        margin-top: 10px;
      }

      .pagination button {
        margin-left: 0;
        margin-bottom: 4px;
      }
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }
  </style>

  </main>
</head>

<body class="sb-nav-fixed">
  <?php include 'navbar-top.php'; ?>

  <div id="layoutSidenav">
    <?php include 'sidebar.php'; ?>

    <div id="layoutSidenav_content">
      <main id="main">