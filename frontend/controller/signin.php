<?php
require __DIR__ . '/../../src/config.php';
require __DIR__ . '/../../src/functions.php';

if (isset($_POST['login_btn'])) {
    // Retrieve Records
    $password = parse_input($_POST['password']);
    $email = parse_input($_POST['email']);

    $passwordErr = $emailErr = "";

    // Check for empty fields
    if (empty($password) || empty($email)) {
        if (empty($password)) {
            $passwordErr = "password required";
        }
        if (empty($email)) {
            $emailErr = "email required";
        }
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if ($data) {
            $data = (object) $data;
            if ($data->verify_status != 1) {
                $_SESSION['message'] = "Verify your account and try again!";
                $_SESSION['message_code'] = "warning";
                header("Location: /login");
                exit(0);
            } else {

                if (!password_verify($password, $data->password)) {
                    $_SESSION['message'] = "incorrect username or password!";
                    $_SESSION['message_code'] = "warning";
                    header("Location: /login");
                    exit(0);
                }

                $_SESSION['auth'] = true;
                $_SESSION['auth_role'] = $data->role_as; // 1=admin $ 0=user
                // we will store data in array formart
                $_SESSION['auth_user'] = [
                    'user_id' => $data->id,
                    'user_name' => $data->fname . ' ' . $data->lname,
                    'user_gender' => $data->gender,
                    'user_department' => $data->department,
                    'user_email' => $data->email,
                ];

                // lets redirect to Admin or normal user
                if ($_SESSION['auth_role'] == "1") // admin
                {
                    $_SESSION['message'] = "Welcome to admin dashboard";
                    $_SESSION['message_code'] = "success";
                    header("Location: /admin/dashboard"); // admin panel path
                    exit(0);
                } elseif ($_SESSION['auth_role'] == "0") {
                    $_SESSION['message'] = "Welcome to employee dashboard";
                    $_SESSION['message_code'] = "success";
                    header("Location: /employee/dashboard"); // Homepage itself path
                    exit(0);
                }
            }
        } else {
            $_SESSION['message'] = "user credentials does not match";
            $_SESSION['message_code'] = "warning";
            header("Location: /login");
            exit(0);
        }
    }
}