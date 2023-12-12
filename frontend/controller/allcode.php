<?php
session_start();
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

if (isset($_POST['logout_btn'])) {
  // session_destroy();
  unset($_SESSION['auth']);
  unset($_SESSION['auth_role']);
  unset($_SESSION['auth_user']);

  $_SESSION['message'] = "Logged Out Successfully";
  $_SESSION['message_code'] = "success";
  header("Location: /");
  exit(0);
}


if (isset($_POST['reset_password'])) {
  $reset_token = parse_input($_POST['code']);
  $new_password = parse_input($_POST['new_password']);
  $confirm_password = parse_input($_POST['confirm_password']);

  if ($new_password === $confirm_password) {
    $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

    // Check if the reset code is valid and not expired
    $query = "SELECT email FROM users WHERE reset_token = :reset_token";

    $stmt = $conn->prepare($query);
    $stmt->execute(['reset_token' => $reset_token]);
    $data = $stmt->fetch();

    if ($data) {
      $data = (object) $data;

      $update_data = [
        'email' => $data->email,
        'reset_token_expiration' => NULL,
        'reset_token' => NULL,
        'password' => $new_password_hash,
      ];
      // Update the user's password
      $update_sql = "UPDATE users SET password = :password, reset_token = :reset_token, reset_token_expiration = :reset_token_expiration WHERE email = :email";
      $stmt = $conn->prepare($update_sql);
      if ($stmt->execute($update_data)) {
        $_SESSION['message'] = "Password reset successfully.";
        $_SESSION['message_code'] = "success";
        header("Location: /login");
        exit(0);
      }
    } else {
      $_SESSION['message'] = "Invalid or expired reset code. Please try again.";
      $_SESSION['message_code'] = "warning";
      header("Location: /reset_password?code={$reset_token}");
      exit(0);
    }
  } else {
    $_SESSION['message'] = "Password and confirm password does not match";
    $_SESSION['message_code'] = "success";
    header("Location: /reset_password?code={$reset_token}");
    exit(0);
  }
}