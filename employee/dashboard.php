<div class="container-fluid px-4">
    <h1 class="mt-4">User Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <?php include('message.php') ?>
    <div class="row">

        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Total Applied leaves</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?php
                        $email = $_SESSION['auth_user']['user_email'];
                        $query = "SELECT id FROM apply_leave WHERE email = :email";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(['email' => $email]);
                        $data = $stmt->fetchAll();
                        if ($data) {
                            echo '<h1>' . count($data) . '</h1>';
                        } else {
                            echo '<h1>' . 0 . '</h1>';
                        }
                        ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-info text-primary mb-4">
                <div class="card-body">Total Leave Types</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?php
                        $query = "SELECT * FROM leave_type ORDER BY id";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $data = $stmt->fetchAll();
                        if ($data) {
                            echo '<h1>' . count($data) . '</h1>';
                        } else {
                            echo '<h1>' . 0 . '</h1>';
                        }
                        ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">My Department</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?php
                        $email = $_SESSION['auth_user']['user_email'];
                        $query = "SELECT department FROM users WHERE email = :email";
                        $stmt = $conn->prepare($query);
                        $stmt->execute(['email' => $email]);
                        $data = $stmt->fetch();
                        if ($data) {
                            echo '<h1>' . count($data) . '</h1>';
                        } else {
                            echo '<h1>' . 0 . '</h1>';
                        }
                        ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

require __DIR__ . "/includes/footer.php";