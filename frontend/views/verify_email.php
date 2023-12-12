<?php
session_start();
require __DIR__ . '/../../src/config.php';
require __DIR__ . '/../../src/functions.php';

if (isset($_GET['token'])) {
    $verify_token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM users WHERE verify_token = :verify_token LIMIT 1";
    $stmt = $conn->prepare($verify_query);
    $stmt->execute(['verify_token' => $verify_token]);
    $data = $stmt->fetch();

    if ($data) {
        $data = (object) $data;
        if ($data->verify_status == "0") {
            $verify_token = $data->verify_token;
            $data = [
                "verify_token" => $verify_token,
                "verify_status" => '1'
            ];
            $update_query = "UPDATE users SET verify_status = :verify_status WHERE verify_token = :verify_token LIMIT 1";
            $stmt = $conn->prepare($update_query);

            if ($stmt->execute($data)) {
                $_SESSION['message'] = "Account is Verified Successfully!";
                $_SESSION['message_code'] = "success";
                header("Location: /login");
                exit(0);
            } else {
                $_SESSION['message'] = "Verification failed!";
                $_SESSION['message_code'] = "warning";
                header("Location: /login");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Email has been verified already!";
            $_SESSION['message_code'] = "info";
            header("Location: /login");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Expired or wrong token!";
        $_SESSION['message_code'] = "error";
        header("Location: /login");
        exit(0);
    }
}
?>