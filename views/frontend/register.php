<?php
$departments = $data ? $data->departments : null;
?>

<main id="register">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
            
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-register-image bg-blue"></div>
                        <div class="col-lg-7">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" action="/register" method="post">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="first_name" class="form-control form-control-user"
                                                id="exampleFirstName" placeholder="First Name">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="last_name" class="form-control form-control-user"
                                                id="exampleLastName" placeholder="Last Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            id="exampleInputEmail" placeholder="Email Address">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <select name="department_id" required class="form-control form-control-select">
                                                <option value="">--Select Department--</option>
                                                <?php
                                                    if ($departments) {
                                                        foreach ($departments as $row) {
                                                            echo "<option value=" . $row->id . ">" . $row->name . "</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="gender" class="form-control form-control-select" required>
                                                <option value="">--Select Gender--</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" name="password"
                                                class="form-control form-control-user" id="exampleInputPassword"
                                                placeholder="Password">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" name="confirm_password"
                                                class="form-control form-control-user" id="exampleRepeatPassword"
                                                placeholder="Confirm Password">
                                        </div>
                                    </div>
                                    <input type="submit" name="submit" value="Register Account" class="btn btn-primary btn-user btn-block"/>
                                    <hr>

                                    <a href="#" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Register with Google
                                    </a>
                                    <a href="#" class="btn btn-facebook btn-user btn-block">
                                        <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/forgot/password">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/login">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>




