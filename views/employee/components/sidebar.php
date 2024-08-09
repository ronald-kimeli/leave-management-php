<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">MENU</div>

                <a class="nav-link" href="/employee/dashboard">
                    <div class="sb-nav-link-icon"><i class="bi bi-grid"></i></div>
                    Dashboard
                </a>

                <a class="nav-link" href="/employee/department">
                    <div class="sb-nav-link-icon"><i class="bi bi-building-check"></i></div>
                    Department
                </a>

                <a class="nav-link" href="/employee/appliedleaves">
                    <div class="sb-nav-link-icon"><i class="bi bi-arrow-repeat"></i></div>
                    Applied Leaves
                </a>

                <a class="nav-link" href="/employee/leavetypes">
                    <div class="sb-nav-link-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    Leave Types
                </a>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php if (isset($_SESSION['auth_user'])): ?>
                    <?= $_SESSION['auth_user']['user_name'] ?>
                <?php endif; ?>
            </div>
    </nav>
</div>