<?php
// Header template
require __DIR__ ."/../includes/header.php";

?>

<main id="forgot-password">
    <?php require __DIR__ ."/../messages/message.php"; ?>
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image bg-blue"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                    <p class="mb-4">Enter your email address below
                                        and we'll send you a link to reset your password!</p>
                                    <form class="user" action="/reset-password" method="post">
                                        <div class="form-group mb-2">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <button type="submit" name="submitreset"
                                            class="btn btn-primary btn-user btn-block">Reset
                                            password</button>
                                    </form>
                                </div>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/register">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/login">Already have an account? Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Scripts
require __DIR__ ."/../includes/scripts.php";