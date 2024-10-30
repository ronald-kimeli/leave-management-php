<?php

namespace app\controllers;

use app\models\User;
use app\Responses\View;
use app\models\Department;
use app\controllers\Controller;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class FrontEndController extends Controller
{
    public function index()
    {
        $headerTitle = 'Home';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('frontend.welcome', null, $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }

        return View::render('frontend.welcome', null, $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function registerForm()
    {
        $departments = Department::model()->all();

        $headerTitle = 'Sign Up';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('frontend.register', ['departments' => $departments], $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }

        return View::render('frontend.register', ['departments' => $departments], $headerTitle, $message = null, $messageCode = null, 200);
    }
    public function showResetPasswordForm($request)
    {
        $reset_token = $this->parseInput($request['code']);
        if (empty($reset_token)) {
            return View::redirect('/forgot/password', "Invalid reset token.", "error", 302);
        }

        // Check if the reset token is valid and not expired
        $user = User::model()->where(['reset_token' => $reset_token])
            ->where(['reset_token_expiration', '>', date('Y-m-d H:i:s')])
            ->one();

        if ($user) {
            // Token is valid, show the reset password form
            return View::render('frontend.reset_password', ['token' => $reset_token]);
        } else {
            return View::redirect('/forgot/password', "Invalid or expired reset token.", "error", 302);
        }
    }

    public function resetPassword($request)
    {
        if (isset($request['submitreset'])) {
            // Retrieve and sanitize email input
            $email = $this->parseInput($request['email']);
            $emailErr = "";

            // Check for empty fields
            if (empty($email)) {
                $emailErr = "Email is required";
                return View::redirect('/forgot/password', $emailErr, "error", 302);
            } else {
                // Use ORM to find the user by email
                $user = User::model()->where(['email' => $email])->get()[0];

                if ($user) {
                    // Generate a random reset code
                    $reset_token = bin2hex(random_bytes(16));

                    // Set the reset expiration time (e.g., 1 hour from now)
                    $reset_token_expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

                    // Update the user's record with the reset code and expiration time
                    $user->reset_token = $reset_token;
                    $user->reset_token_expiration = $reset_token_expiration;

                    if ($user->update()) {
                        // Send the reset token to the user
                        $send_verification = $this->sendemail_resetToken($email, $reset_token);

                        if ($send_verification) {
                            return View::redirect('/login', "We have emailed the reset code, check and proceed!", "success", 302);
                        } else {
                            return View::redirect('/forgot/password', "Failed to send reset code. Please try again.", "error", 302);
                        }
                    } else {
                        return View::redirect('/forgot/password', "Failed to update reset token. Please try again.", "error", 302);
                    }
                } else {
                    return View::redirect('/register', "Credentials do not match! Try registering first.", "error", 302);
                }
            }
        }
    }

    public function processPasswordReset($request)
    {
        if (isset($request['reset_password'])) {
            $reset_token = $this->parseInput($request['code']);
            $new_password = $this->parseInput($request['new_password']);
            $confirm_password = $this->parseInput($request['confirm_password']);

            if ($new_password === $confirm_password) {
                $new_password_hash = password_hash($new_password, PASSWORD_BCRYPT);

                // Check if the reset token is valid and not expired
                $user = User::model()->where(['reset_token' => $reset_token])
                    ->where(['reset_token_expiration', '>', date('Y-m-d H:i:s')])
                    ->one();

                if ($user) {
                    // Update the user's password and reset token fields
                    $user->password = $new_password_hash;
                    $user->reset_token = null;
                    $user->reset_token_expiration = null;

                    $response = $user->save();

                    if ($response['status'] === 'success') {
                        $_SESSION['message'] = "Password reset successfully.";
                        $_SESSION['message_code'] = "success";
                        return View::redirect('/login', "Password reset successfully. You can now log in.", "success", 302);
                    } else {
                        $_SESSION['message'] = "Failed to reset password. Please try again.";
                        $_SESSION['message_code'] = "error";
                        return View::redirect('/reset_password?code={$reset_token}', "Failed to reset password. Please try again.", "error", 302);
                    }
                } else {
                    $_SESSION['message'] = "Invalid or expired reset token.";
                    $_SESSION['message_code'] = "error";
                    return View::redirect('/forgot/password', "Invalid or expired reset token.", "error", 302);
                }
            } else {
                $_SESSION['message'] = "Password and confirm password do not match.";
                $_SESSION['message_code'] = "error";
                return View::redirect('/reset_password?code={$reset_token}', "Password and confirm password do not match.", "error", 302);
            }
        }
    }

    public function register($request)
    {
        if (isset($request['submit'])) {
            $user = new User();
            $user->first_name = $this->parseInput($request['first_name']);
            $user->last_name = $this->parseInput($request['last_name']);
            $user->gender = $this->parseInput($request['gender']);
            $user->department_id = $this->parseInput($request['department_id']);
            $user->email = $this->parseInput($request['email']);
            $user->password = password_hash($request['password'], PASSWORD_DEFAULT);
            $user->verify_token = md5(rand());

            if ($request['password'] == $request['confirm_password']) {
                $checkemail = User::model()->where(['email' => $user->email])->get();
                if (count($checkemail) > 0) {
                    return View::redirect('/register', "Email has already been taken", "error", 302);
                } else {
                    $response = $user->save();
                    if ($response['status'] === 'error') {
                        return View::redirect('/register', $response['message'], "error", 302);
                    } else if ($response['status'] === 'success') {
                        $send_verification = $this->sendemail_verify("$user->first_name", "$user->last_name", "$user->email", "$user->verify_token");
                        if ($send_verification) {
                            return View::redirect('/login', 'Registered successfully! Please verify your Email address to login!', "success", 302);
                        }
                    }
                }
            } else {
                return View::redirect('/register', "Password and Confirm Password does not match", "error", 302);
            }
        }
    }

    public function login()
    {
        $headerTitle = 'Login';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('frontend.login', null, $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }
        return View::render('frontend.login', null, $headerTitle, $message = null, $messageCode = null, 200);
    }

    public function signin($request)
    {
        if ($request['login_btn'] === "Login") {
            $password = $this->parseInput($request['password']);
            $email = $this->parseInput($request['email']);

            // Check for empty fields
            if ($password === "" && $email !== "") {
                return View::redirect('/login', "Password is required", "warning", 302);
            } elseif ($password !== "" && $email === "") {
                return View::redirect('/login', "Email is required", "warning", 302);
            } elseif ($password == "" && $email == "") {
                return View::redirect('/login', "email or password should not be empty", "warning", 302);
            } else {
                $data = User::model()->where(['email' => $email])->get();

                if ($data) {
                    $data = $data[0];

                    if ($data->verify_status === 'pending') {
                        return View::redirect('/login', "Verify your account and try again!", "warning", 302);
                    } else {

                        if (!password_verify($password, $data->password)) {
                            return View::redirect('/login', "incorrect username or password!", "warning", 302);
                        }

                        $_SESSION['auth'] = true;
                        $_SESSION['auth_role'] = $data->role->name;
                        $_SESSION['auth_user'] = [
                            'user_email' => $data->email,
                            'user_name' => $data->first_name . ' ' . $data->last_name,
                        ];
                        
                        $_SESSION['session_start_time'] = time();

                        // lets redirect to Admin or normal user
                        if ($_SESSION['auth_role'] == "admin") // admin
                        {
                            return View::redirect('/admin/dashboard', "Welcome to admin dashboard", "success", 302);
                        } elseif ($_SESSION['auth_role'] == "employee") {
                            return View::redirect('/employee/dashboard', "Welcome to employee dashboard", "success", 302);
                        } else {
                            return View::redirect('/login', "Unauthorized! contact the administrator", "error", 302);
                        }
                    }
                } else {
                    return View::redirect('/login', "user credentials does not match", "warning", 302);
                }
            }
        } else {
            return View::redirect('/login', "Method Not allowed", "success");
        }
    }
    public function forgotPassword()
    {
        $headerTitle = 'Forgot Password';
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            return View::render('frontend.forgotPassword', null, $headerTitle, $_SESSION['message'], $_SESSION['message_code'], 200);
        }

        return View::render('frontend.forgotPassword', null, $headerTitle, $message = null, $messageCode = null, 200);
    }
    private function sendemail_resetToken($email, $code)
    {
        try {
            $config = require (__DIR__ . '/../../src/smtp.php');
            $smtp = $config['smtp'];
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = $smtp['host'];
            $mail->Username = $smtp['username'];
            $mail->Password = $smtp['password'];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom($smtp['from']);
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

    private function sendemail_verify($fname, $lname, $email, $verify_token)
    {
        try {
            $config = require (__DIR__ . '/../../src/smtp.php');
            $smtp = $config['smtp'];
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->SMTPAuth = true;

            $mail->Host = $smtp['host'];
            $mail->Username = $smtp['username'];
            $mail->Password = $smtp['password'];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; 

            $mail->setFrom($smtp['from'], $fname . ' ' . $lname);
            $mail->addAddress($email); 

            $mail->isHTML(true);
            $mail->Subject = "Account Verification from Leave Management System";
            $mail_template = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        color: #333;
                        margin: 0;
                        padding: 20px;
                        background-color: #f4f4f4;
                    }
                    .container {
                        max-width: 600px;
                        margin: auto;
                        padding: 20px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    }
                    h2 {
                        color: #2c3e50;
                    }
                    h5 {
                        color: #7f8c8d;
                    }
                    a {
                        display: inline-block;
                        margin-top: 10px;
                        padding: 10px 20px;
                        font-size: 16px;
                        color: #fff;
                        background-color: #3498db;
                        text-decoration: none;
                        border-radius: 5px;
                    }
                    a:hover {
                        background-color: #2980b9;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <h2>Welcome to Leave Management System!</h2>
                    <h5>Thank you for registering. Please verify your email address by clicking the link below:</h5>
                    <a href='http://localhost:8000/verify_email?token=$verify_token'>Verify Your Email</a>
                </div>
            </body>
            </html>
            ";
            $mail->Body = $mail_template;
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function verifyEmail($query_params)
    {
        if (isset($query_params['token'])) {
            $user = User::model()->where(['verify_token' => $query_params['token']])->get();
            if (count($user) > 0) {
                if ($user[0]->verify_status == "pending") {
                    $user[0]->verify_status = 'verified';
                    if ($user[0]->update()) {
                        return View::redirect('/login', "Your Account is Verified Successfully! Now Login", "success", 302);
                    } else {
                        return View::redirect('/login', "Verification failed!", "warning", 302);
                    }
                } else {
                    return View::redirect('/login', "Email Already verified. Please Login", "info", 302);
                }
            } else {
                return View::redirect('/login', "This token does not exist or expired", "error", 302);
            }
        } else {
            return View::redirect('/login', "Not allowed", "error", 302);
        }
    }

    private function parseInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}
