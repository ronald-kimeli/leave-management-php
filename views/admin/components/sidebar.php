<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">MENU</div>
                <a class="nav-link" href="/admin/dashboard">
                    <div class="sb-nav-link-icon"><i class="bi bi-columns-gap"></i></div>
                    Dashboard
                </a>
                <a class="nav-link" href="/admin/employees">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Employees
                </a>
                <a class="nav-link" href="/admin/departments">
                    <div class="sb-nav-link-icon"><i class="bi bi-diagram-3-fill"></i></div>
                    Departments
                </a>
                <a class="nav-link" href="/admin/appliedleaves">
                    <div class="sb-nav-link-icon"><i class="bi bi-person-fill-check"></i></div>
                    Applied Leaves
                </a>
                <a class="nav-link" href="/admin/leavetypes">
                    <div class="sb-nav-link-icon"><i class="bi bi-list-ol"></i></div>
                    Leave Types
                </a>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php 
                if (isset($_SESSION['auth_user'])): ?>
                    <?=$_SESSION['auth_user']['user_name']?>
                <?php endif;?>
            </div>
    </nav>
</div>