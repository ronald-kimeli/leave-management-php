<?php
session_start();
if (isset($_SESSION['auth'])) // prevents showing login page while loggedd in
{
    if (!isset($_SESSION['message'])) { //makes it unauthorized while accessing admin panel
        $_SESSION['message'] = "You are already Logged In";
    }
    header("Location:index.php"); //..to home page
    exit(0);
}

include('includes/header.php');
include('includes/navbar.php');
?>

<?php include('message.php'); ?>
<section class="wrapper" id="wrapper">
    <div class=" py-5">
        <div class="container ">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header">
                            <h4>Login</h4>
                        </div>
                        <div class="card-body">

                            <form action="logincode.php" method="post">
                                <div class="form-group mb-3">
                                    <label>Email address</label>
                                    <input type="email" name="email" placeholder="Enter Email Adress" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Password</label>
                                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <button type="submit" name="login_btn" class="btn btn-primary">Login Now</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/footer.php');
    ?>