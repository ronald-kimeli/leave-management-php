<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">MENU</div>
                <?php foreach (require __DIR__ . '/menu.php' as $item): ?>
                    <?php if (in_array($role, $item['roles'], true)): ?>
                        <a class="nav-link" href="/<?= $role ?>/<?= $item['path'] ?>">
                            <div class="sb-nav-link-icon"><i class="<?= $item['icon'] ?>"></i></div>
                            <?= $item['label'] ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                <?php if (isset($_SESSION['auth_user'])): ?>
                    <?= $_SESSION['auth_user']['user_name'] ?>
                <?php endif; ?>
            </div>
    </nav>
</div>
