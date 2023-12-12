<?php
require "src/config.php";
require_once "src/functions.php";

// Admin Routes
if (isset($_POST['delete_dept'])) {
    $user_id = parse_input($_POST['delete_dept']);

    $query = "DELETE FROM department WHERE id = :id "; // Delete departnent
    $stmt = $conn->prepare($query);

    if ($stmt->execute(array("id" => $user_id))) {
        $_SESSION['message'] = "Deleted Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/departments");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/departments");
        exit(0);
    }
}

if (isset($_POST['delete_ltype'])) {
    $user_id = parse_input($_POST['delete_ltype']);

    $query = "DELETE FROM leave_type WHERE id = :id"; // Delete leave type
    $stmt = $conn->prepare($query);

    if ($stmt->execute(array("id" => $user_id))) {
        $_SESSION['message'] = "Deleted Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/leavetypes");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/leavetypes");
        exit(0);
    }
}

// Receive from ajax
if (isset($_POST['add_dept'])) {
    $errors = [];
    $data = [];

    if (empty($_POST['dpname'])) {
        $errors['dpname'] = 'Department Name is required.';
    }

    $dpname = parse_input($_POST['dpname']);

    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors'] = $errors;

        $_SESSION['message'] = $errors['dpname'];
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/add-dept");
        exit(0);
    } else {
        $query = "INSERT INTO department (dpname) values(:dpname)";
        $stmt = $conn->prepare($query);
        if ($stmt->execute(array("dpname" => $dpname))) {
            $data['success'] = true;
            $data['message'] = 'Department Added Successfully';

            $_SESSION['message'] = $data['message'];
            $_SESSION['message_code'] = "success";
            header("Location: /admin/departments");
            exit(0);
        }
    }

}

if (isset($_POST['update_dept'])) {
    $user_id = parse_input($_POST['user_id']); //department
    $dpname = parse_input($_POST['dpname']);

    $query = "UPDATE department SET dpname= :dpname
                 WHERE id = :id ";

    $stmt = $conn->prepare($query);

    if ($stmt->execute(["dpname" => $dpname, "id" => $user_id])) {
        $_SESSION['message'] = "Updated Department Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/departments");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/departments");
        exit(0);
    }
}

if (isset($_POST['update_ltype'])) {
    $user_id = parse_input($_POST['user_id']); //update leave_type
    $leave_type = parse_input($_POST['leave_type']);

    $query = "UPDATE leave_type SET leave_type= :leave_type
                 WHERE id = :id ";

    $stmt = $conn->prepare($query);

    if ($stmt->execute(["leave_type" => $leave_type, "id" => $user_id])) {
        $_SESSION['message'] = "Updated Leave Type Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/leavetypes");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/leavetypes");
        exit(0);
    }
}

if (isset($_POST['add_ltype'])) {
    $leave_type = parse_input($_POST['leave_type']);

    $query = "INSERT INTO leave_type (leave_type)
  values(:leave_type)";

    $stmt = $conn->prepare($query);

    if ($stmt->execute(["leave_type" => $leave_type])) {
        $_SESSION['message'] = "Leave Type Added Successfully";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/leavetypes");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/leavetypes");
        exit(0);
    }
}

if (isset($_POST['update_status'])) {
    $id = parse_input($_POST['id']);
    $leave_status = parse_input($_POST['leave_status']);

    $query = "UPDATE apply_leave SET leave_status= :leave_status
                 WHERE   id = :id ";

    $stmt = $conn->prepare($query);

    if ($stmt->execute(["leave_status" => $leave_status, "id" => $id])) {
        $_SESSION['message'] = "Update success";
        $_SESSION['message_code'] = "success";
        header("Location: /admin/appliedleaves");
        exit(0);
    } else {
        $_SESSION['message'] = "Error occurred processing! contact administrator";
        $_SESSION['message_code'] = "warning";
        header("Location: /admin/appliedleaves");
        exit(0);
    }
}

// if(isset($_POST['delete_leave']))
// {
//   $leave_id = $_POST['delete_leave'];

//   $query = "DELETE FROM apply_leave WHERE leave_id = $leave_id ";// Delete leave
//   $query_run = mysqli_query($con,$query);

//   if($query_run)
//   {
//     $_SESSION['message'] = "Deleted Successfully";
//     header ("Location: appliedleaves.php");
//     exit(0);
//   }
// }
