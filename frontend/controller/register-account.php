<?php
session_start();
require __DIR__ . '/../src/config.php';
require __DIR__ . '/../src/functions.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verify($fname, $lname, $email, $verify_token)
{
  try {
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "smtp.gmail.com";
    $mail->Username = "leavemanagement254@gmail.com"; //SMTP username
    $mail->Password = "xjssirazbecywkjg "; // Alloweduser254

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom("leavemanagement254@gmail.com", $fname . '' . $lname);
    $mail->addAddress($email); //Add a recipient

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = "Email Verification from Leave_Management System";

    $mail_template = "
  <h2> You have registered with Leave_management System</h2>
  <h5> Verify your email address to Login with the given link below</h5>
  <br/><br/>
 
  <a href='http://localhost:8000/verify_email?token=$verify_token'>Click me</a>
  ";

    $mail->Body = $mail_template;
    $mail->send();
  } catch (Exception $e) {
    $_SESSION['message'] = $e->errorMessage();
    $_SESSION['message_code'] = "error";
    header("Location: /forgot-password");
    exit(0);
  }
}

if (isset($_POST['submit'])) {
  $fname = parse_input($_POST['fname']);
  $lname = parse_input($_POST['lname']);
  $gender = parse_input($_POST['gender']);
  $department = parse_input($_POST['department']);
  $email = parse_input($_POST['email']);
  $password = parse_input($_POST['password']);
  $cpassword = parse_input($_POST['cpassword']);
  $new_password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
  $verify_token = md5(rand()); //integers and random alphabets

  if ($password == $cpassword) {
    //  check Email
    $checkemail = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($checkemail);
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();

    if ($data) {
      // Email Already  Exists
      $_SESSION['message'] = "Email has already been taken";
      $_SESSION['message_code'] = "error";
      header("Location: /register");
      exit(0);
    } else {
      $data = [
        'fname' => $fname,
        'lname' => $lname,
        'gender' => $gender,
        'department' => $department,
        'email' => $email,
        'password' => $password,
        'verify_token' => $verify_token,
      ];
      $sql = "INSERT INTO users (fname,lname,gender,department,email, password,verify_token) VALUES (:fname,:lname,:gender,:department,:email, :password,:verify_token)";
      $stmt = $conn->prepare($sql);
      if ($stmt->execute($data)) {
        sendemail_verify("$fname", "$lname", "$email", "$verify_token");
        $_SESSION['message'] = "Registered! Check your email to verify account and login!";
        $_SESSION['message_code'] = "success";
        header("Location: /login");
        exit(0);
      } else {
        $_SESSION['message'] = "Error occurred while processing! Contact administrator";
        $_SESSION['message_code'] = "error";
        header("Location: /register");
        exit(0);
      }
    }
  } else {
    $_SESSION['message'] = "Password and Confirm Password does not match";
    $_SESSION['message_code'] = "error";
    header("Location: /register");
    exit(0);
  }
}