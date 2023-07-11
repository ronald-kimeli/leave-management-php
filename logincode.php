<?php
session_start();
include('admin/config/dbcon.php');
// once the login is clicked
if(isset($_POST['login_btn']))
{
    // sql injection passing
    $email = mysqli_real_escape_string($con,$_POST['email']);
    $password = mysqli_real_escape_string($con,$_POST['password']);

    $login_query = " SELECT * FROM users WHERE email = '$email' 
    AND password = '$password'  LIMIT 1";
    $login_query_run = mysqli_query($con, $login_query);// result

    if(mysqli_num_rows($login_query_run)>0)
    {
        $row = mysqli_fetch_array($login_query_run);
        //  echo $row['verify_status'];
        if($row['verify_status'] == "0")
         {
            $_SESSION['message'] = "You need to verify account and login!";
            $_SESSION['message_code'] = "warning";
            header("Location: login.php");
            exit(0); 
         }
        else
    {

        foreach($login_query_run as $data)
        {
            $user_id = $data['id'];
            // lets concatinet
            $user_name = $data['fname'].' '.$data['lname'];
            $user_gender = $data['gender'];
            $user_department = $data['department'];
            $user_email = $data['email'];
            
            // if the role is 0,will be normal user
            $role_as = $data['role_as'];
        }
            $_SESSION['auth'] = true;
            $_SESSION['auth_role'] = "$role_as"; // 1=admin $ 0=user
            // we will store data in array formart
            $_SESSION['auth_user'] = [
                'user_id' => $user_id,
                'user_name' => $user_name,
                'user_gender' => $user_gender,
                'user_department' => $user_department,
                'user_email' => $user_email,
                
            ];

            // lets redirect to Admin or normal user
      if($_SESSION['auth_role'] == "1")  // admin
      {
        $_SESSION['message'] = "Welcome to dashboard";
        header("Location:admin/index.php");// admin panel path
        exit(0);
      }
      elseif($_SESSION['auth_role'] == "0")
      {
        $_SESSION['message'] = "Logged In Successfully";
        $_SESSION['message_code'] = "success";
        header("Location:includes/dashboard.php"); // Homepage itself path
        exit(0);    
      }
     }
    }
    else
    {
        $_SESSION['message'] = "Invalid Email or Password";
        $_SESSION['message_code'] = "warning";
    header("Location:login.php");  
    exit(0);
    }
}
else
{
    $_SESSION['message'] = "You are not allowed to access this file";
    $_SESSION['message_code'] = "info";
    header("Location:login.php");  
    exit(0);
}
