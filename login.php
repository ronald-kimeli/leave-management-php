<?php
session_start();
if (isset($_SESSION['auth'])) // prevents showing login page while loggedd in
{
    if (!isset($_SESSION['message'])) { //makes it unauthorized while accessing admin panel
        $_SESSION['message'] = "You are already Logged In";
    }
    header("Location:userDashboard.php"); //..to home page
    exit(0);
}

include('includes/header.php');
include('includes/navbar.php');
?>

<?php include('message.php'); ?>
<section class="wrapper" id="wrapper">
    <div class="container py-5" id="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php include('message.php'); ?>
                <div class="card shadow rounded">
                    <div class="card-header">
                            <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action="logincode.php" method="post">
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Email address:</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" placeholder="Enter Email Adress" class="form-control">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Password:</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" placeholder="Enter Password" class="form-control">
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="login_btn" class="btn btn-primary">Login Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include('includes/footer.php');
?>