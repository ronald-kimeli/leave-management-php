<?php if (isset($_SESSION['auth_user'])) : ?>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        LEAVE Application
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="applyleave.php">Apply Leave</a>
        <li>
        <li><a class="dropdown-item" href="leavestatus.php">Leave Status</a>
        <li>
    </ul>
</li>

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <?= $_SESSION['auth_user']['user_name']  ?>
    </a>
    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        <li><a class="dropdown-item" href="#">My Profile</a></li>
        <li>
            <form action="allcode.php" method="post">
                <button class="dropdown-item" name="logout_btn" type="submit">Logout</button>
            </form>
        </li>
    </ul>
</li>

<?php else : ?>
<li class="nav-item">
    <a class="nav-link" href="login.php">LOGIN</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="register.php">REGISTER</a>
</li>

<?php endif; ?>