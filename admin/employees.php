<div class="container-fluid px-4">
    <h4 class="mt-4">Users</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item ">Users</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?php include 'message.php';?>
            <div class="card shadow ">
                <div class="card-header">
                    <h4 class="box-title">Registered Users
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary float-end">
                        <a class="text-white text-decoration-none" href="/admin/register_admin">ADD USER</a>
            </button>
                    </h4>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped table-responsive">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                                <th>Department</th>
                                <th>Email</th>
                                <th>Role_as</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
$email = $_SESSION['auth_user']['user_email'];
$query = "SELECT * FROM users WHERE NOT (email = :email)";
$stmt = $conn->prepare($query);
$stmt->execute(['email' => $email]);
$data = $stmt->fetchAll();
if ($data) {
    foreach ($data as $row) {
        // lets divide php
        ?>
                                    <tr>
                                        <td>
                                            <?=$row['id'];?>
                                        </td>
                                        <td>
                                            <?=$row['fname'];?>
                                        </td>
                                        <td>
                                            <?=$row['lname'];?>
                                        </td>
                                        <td>
                                            <?=$row['gender'];?>
                                        </td>
                                        <td>
                                            <?=$row['department'];?>
                                        </td>
                                        <td>
                                            <?=$row['email'];?>
                                        </td>
                                        <td>
                                            <?php
if ($row['role_as'] == '1') {
            echo 'Admin';
        } elseif ($row['role_as'] == '0') {
            echo 'User';
        }
        ?>
                                        </td>
                                        <!-- sending fetched id -->
                                        <td><a href="/admin/register_edit?id=<?=$row['id'];?>"
                                                class="btn btn-success">Edit</a>
                                        </td>
                                        <td>
                                            <form action="/admin/codeu" method="post">
                                                <button type="submit" name="delete_user" value="<?=$row['id'];?>"
                                                    class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
}
} else {
    ?>
                                <tr>
                                    <td colspan="6"> No Record Found</td>
                                </tr>
                                <?php
}
?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php

require __DIR__ . "/includes/footer.php";