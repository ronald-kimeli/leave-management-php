
<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img src="/frontend/assets/images/leave2-logo.png" alt="leave-logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['auth_user'])) : ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link active dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Showing who is logged in instead of Dropdown -->
                            <?= $_SESSION['auth_user']['user_name'] ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="/profile">My Profile</a></li>
                            <li>
                                <form action="/allcode" method="post">
                                    <button class="dropdown-item" name="logout_btn" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>

                    <?php else : ?>

                    <li class="nav-item mr-auto"><a href="/login" class="btn btn-danger">Login</a></li>
                    <li class="nav-item mr-auto"><a href="/register" class="btn btn-success">Register</a></li>

                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </nav>
</section>