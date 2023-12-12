<?php
require "src/config.php";
require_once "src/functions.php";

// Extend admin functions
if (isset($_POST['delete_user'])) {
    $user_id = parseInput($_POST['delete_user']);
    $query = "DELETE FROM users WHERE id = :id"; // Delete user
    $stmt = $conn->prepare($query);

    if ($stmt->execute(array("id" => $user_id))) {
        $_SESSION['message'] = "User deleted successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/employees");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/employees");
        exit(0);
    }
}

if (isset($_POST['add_admin'])) // add admin/user
{
    $fname = parseInput($_POST['fname']);
    $lname = parseInput($_POST['lname']);
    $gender = parseInput($_POST['gender']);
    $department = parseInput($_POST['department']);
    $email = parseInput($_POST['email']);
    $password = parseInput($_POST['password']);
    $cpassword = parseInput($_POST['cpassword']);
    $new_password_hash = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role_as = parseInput($_POST['role_as']);
    $status = $_POST['status'] == true ? '1' : '0';

    if ($password == $cpassword) {
        //  check Email
        $checkemail = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($checkemail);
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch();

        if ($data) {
            // Email Already  Exists
            $_SESSION['message'] = "Email has already been taken";
            $_SESSION['message_code'] = "warning";
            header("Location: /admin/register_admin");
            exit(0);
        } else {
            $data = [
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'department' => $department,
                'email' => $email,
                'password' => $new_password_hash,
                'verify_token' => '',
                'role_as' => $role_as,
                'status' => $status,
            ];
            $sql = "INSERT INTO users (fname,lname,gender,department,email, password,verify_token,role_as,status)
      VALUES (:fname,:lname,:gender,:department,:email, :password,:verify_token,:role_as,status)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute($data)) {

                $_SESSION['message'] = "User created successfully!";
                $_SESSION['message_code'] = "success";
                header("Location: /admin/register_admin");
                exit(0);
            } else {
                $_SESSION['message'] = "Error occurred while processing! Contact administrator";
                $_SESSION['message_code'] = "warning";
                header("Location: /admin/register_admin");
                exit(0);
            }
        }
    } else {
        $_SESSION['message'] = "Password and Confirm Password does not match";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/register_admin");
        exit(0);
    }
}

if (isset($_POST['update_user'])) // update user
{
    $user_id = parseInput($_POST['user_id']);
    $fname = parseInput($_POST['fname']);
    $lname = parseInput($_POST['lname']);
    $email = parseInput($_POST['email']);
    $password = parseInput($_POST['password']);
    $new_password_hash = password_hash($password, PASSWORD_BCRYPT);
    $role_as = parseInput($_POST['role_as']);
    $status = $_POST['status'] == true ? '1' : '0';

    $data = [
        'id' => $user_id,
        'fname' => $fname,
        'lname' => $lname,
        'email' => $email,
        'password' => $new_password_hash,
        'role_as' => $role_as,
        'status' => $status,
    ];

    $query = "UPDATE users SET fname = :fname, lname = :lname, email= :email,
                password = :password, role_as = :role_as, status = :status  WHERE id = :id";

    $stmt = $conn->prepare($query);
    if ($stmt->execute($data)) {
        $_SESSION['message'] = "User updated Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/employees");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred while processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/employees");
        exit(0);
    }
}

function parseInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
