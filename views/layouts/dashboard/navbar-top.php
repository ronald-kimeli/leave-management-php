<nav class="sb-topnav navbar navbar-expand navbar-dark text-white bg-primary">
  <!-- Navbar Brand-->
  <a class="navbar-brand ps-3" href="/<?= $role ?>/dashboard"><?= $role === 'admin' ? 'Administrator' : 'Employee' ?></a>
  <!-- Sidebar Toggle-->
  <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i
      class="fas fa-bars"></i></button>
  <!-- Navbar Search-->
  <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
    <div class="input-group">
      <!-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" /> -->
      <!-- <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> -->
    </div>
  </form>
  <!-- Navbar-->
  <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4 ">

    <?php
    // Bell: admins are told about requests waiting for a decision, employees about requests that were decided.
    $leaves = \app\models\AppliedLeave::model();
    if ($role === 'admin') {
        $alertCount = $leaves->where(['status' => 'pending'])->count();
        $alertTitle = "$alertCount pending leave request(s)";
    } else {
        $me = \app\models\User::model()->where(['email' => $_SESSION['auth_user']['user_email']])->get('id')[0] ?? null;
        $alertCount = $me
            ? \app\models\AppliedLeave::model()->where(['applied_by' => $me->id])->count() - \app\models\AppliedLeave::model()->where(['applied_by' => $me->id, 'status' => 'pending'])->count()
            : 0;
        $alertTitle = "$alertCount of your leave request(s) have been decided";
    }
    ?>
    <li class="nav-item mx-1">
      <button type="button" class="nav-link btn btn-link" data-theme-toggle title="Toggle dark mode" aria-label="Toggle dark mode">
        <i class="fas fa-moon fa-fw theme-icon-light"></i>
        <i class="fas fa-sun fa-fw theme-icon-dark"></i>
      </button>
    </li>
    <!-- Nav Item - Alerts -->
    <li class="nav-item dropdown no-arrow mx-1">
      <a class="nav-link dropdown-toggle position-relative" href="/<?= $role ?>/appliedleaves" id="alertsDropdown" role="button"
        title="<?= htmlspecialchars($alertTitle) ?>">
        <i class="fas fa-bell fa-fw"></i>
        <?php if ($alertCount > 0): ?>
          <span class="badge rounded-pill bg-danger position-absolute top-0 start-100 translate-middle-x"
            style="font-size: .65rem"><?= $alertCount > 99 ? '99+' : $alertCount ?></span>
        <?php endif; ?>
      </a>
    </li>

    <li class="nav-item dropdown pe-3">
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <span class="mr-2 d-none d-lg-inline text-white small">
          <?= $_SESSION['auth_user']['user_name'] ?>
        </span>
        <img class="img-profile rounded-circle" src="/assets/frontend/images/user2.webp" alt="Profile"
          style="height: 30px; width: 30px">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-end shadow animated" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="/<?= $role ?>/profile">
          <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
          Profile
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
          Settings
        </a>
        <a class="dropdown-item" href="#">
          <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
          Activity Log
        </a>
        <div class="dropdown-divider"></div>
        <!-- Logout -->
        <form action="/<?= $role ?>/logout" name="logout_form" method="post" style="margin: 0;">
          <button name="logout_btn" type="submit" class="dropdown-item">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
          </button>
        </form>
      </div>
    </li>
  </ul>
</nav>