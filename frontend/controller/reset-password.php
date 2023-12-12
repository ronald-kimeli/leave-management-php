<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../src/config.php';
require __DIR__ . '/../../src/functions.php';
require 'vendor/autoload.php';

function sendemail_resetToken($email, $code)
{
  try {
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->Username = "leavemanagement254@gmail.com";
    $mail->Password = "xjssirazbecywkjg ";

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom("leavemanagement254@gmail.com");
    $mail->addAddress($email);

    //Content
    $mail->isHTML(true);
    $mail->Subject = "Password reset from Leave_Management System";

    $mail_template = "
  <h2> Reset the password using the link</h2>
  <h5> Ensure to reset password before the link expire</h5>
  <br/><br/>
 
  <a href='http://localhost:8000/reset_password?code=$code'>Click me</a>
  ";

    $mail->Body = $mail_template;
    $mail->send();
  } catch (Exception $e) {
    $_SESSION['message'] = $e->errorMessage();
    $_SESSION['message_code'] = "error";
    header("Location: /forgot/password");
    exit(0);
  }
}

if (isset($_POST['submitreset'])) {
  // Retrieve Records
  $email = parse_input($_POST['email']);

  $emailErr = "";

  // Check for empty fields
  if (empty($email)) {
    if (empty($email)) {
      $emailErr = "email required";
      $_SESSION['message'] = $emailErr;
      $_SESSION['message_code'] = "error";
      header("Location: /forgot/password");
      exit(0);
    }
  } else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();

    if ($data) {
      // Generate a random reset code
      $reset_token = bin2hex(random_bytes(16));

      // Set the reset expiration time (e.g., 1 hour from now)
      $reset_token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

      // Update the user's record with the reset code and expiration time
      $sql = "UPDATE users SET reset_token = :reset_token, reset_token_expiration = :reset_token_expiration WHERE email = :email";
      $stmt = $conn->prepare($sql);

      if ($stmt->execute(['email' => $email, 'reset_token' => $reset_token, 'reset_token_expiration' => $reset_token_expiration])) {
        sendemail_resetToken("$email", "$reset_token");
        $_SESSION['message'] = "We have emailed reset code, check and proceed!";
        $_SESSION['message_code'] = "success";
        header("Location: /login");
        exit(0);
      } else {
        $_SESSION['message'] = "Provided email does not match any record! Try register first!";
        $_SESSION['message_code'] = "error";
        header("Location: /register");
        exit(0);
      }
    } else {
      $_SESSION['message'] = "Credentials does not match!";
      $_SESSION['message_code'] = "error";
      header("Location: /register");
      exit(0);
    }
  }
}