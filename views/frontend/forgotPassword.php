
<main id="forgot-password">
    <?php require __DIR__ . "/messages/message.php"; ?>
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-md-12 col-lg-6 bg-password-image bg-blue" style="background-size: cover;"></div>
                        <div class="col-md-12 col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Forgot Your Password?</h1>
                                    <p class="mb-4">Enter your email address below and we'll send you a link to reset
                                        your password!</p>
                                    <form class="user" action="/reset_password" method="post">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <button type="submit" name="submitreset"
                                            class="btn btn-primary btn-user btn-block">Reset Password</button>
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
