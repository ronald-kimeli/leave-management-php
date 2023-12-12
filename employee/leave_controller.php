<?php
require "src/config.php";
require_once "src/functions.php";

if (isset($_POST['apply_leave'])) //apply leave
{
  $fullname = parse_input($_POST['fullname']);
  $email = parse_input($_POST['email']);
  $gender = parse_input($_POST['gender']);
  $department = parse_input($_POST['department']);
  $leave_type = parse_input($_POST['leave_type']);
  $description = parse_input($_POST['description']);
  $leave_from = date('Y-m-d', strtotime($_POST['leave_from']));
  $leave_to = date('Y-m-d', strtotime($_POST['leave_to']));

  $data = [
    'fullname' => $fullname,
    'email' => $email,
    'gender' => $gender,
    'department' => $department,
    'leave_type' => $leave_type,
    'description' => $description,
    'leave_from' => $leave_from,
    'leave_to' => $leave_to,
  ];


  $sql = "INSERT INTO apply_leave (fullname, email, gender, department, leave_type, description, leave_from, leave_to) VALUES (:fullname, :email, :gender, :department, :leave_type, :description, :leave_from, :leave_to)";
  $stmt = $conn->prepare($sql);
  if ($stmt->execute($data)) {
    $_SESSION['message'] = "Application successful!";
    $_SESSION['message_code'] = "success";
    header("Location: /employee/appliedleaves");
    exit(0);
  } else {
    $_SESSION['message'] = "Error occurred while processing! Contact administrator";
    $_SESSION['message_code'] = "warning";
    header("Location: /employee/appliedleaves");
    exit(0);
  }
}



