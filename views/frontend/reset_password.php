<?php /** @var object|null $data View data supplied by the controller. */ ?>
<main id="forgot-password" class="auth-page">
    <?php require __DIR__ ."/messages/message.php"; ?>
    <div class="auth-wrap">
        <div class="auth-card-col">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-password-image bg-blue"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2">Create New Password</h1>
                                    <p class="mb-4 text-success">Reset your password before reset link expires!</p>
                                    <form class="user" action="/new_password" method="post">
                                        <input type="hidden" name="code" value="<?= htmlspecialchars($data->token ?? '') ?>">
                                        <div class="form-group mb-2">
                                            <input type="password" name="new_password" class="form-control form-control-user"
                                                id="newPassword" minlength="8" required
                                                placeholder="Enter New Password">
                                        </div>
                                        <div class="form-group mb-2">
                                            <input type="password" name="confirm_password" class="form-control form-control-user"
                                                id="confirmPassword" minlength="8" required
                                                placeholder="Enter Confirmation Password">
                                        </div>
                                        <button type="submit" name="reset_password" value="1"
                                            class="btn btn-primary btn-user btn-block">Reset
                                            password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

