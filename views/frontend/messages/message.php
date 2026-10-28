<?php
// Flash message shown as a dismissible Bootstrap alert (no external dialog library).
if (isset($_SESSION['message'])) {
    $flash = (string) $_SESSION['message'];
    $flashType = $_SESSION['message_code'] ?? 'info';
    $flashType = ['error' => 'danger', 'danger' => 'danger', 'success' => 'success', 'warning' => 'warning'][$flashType] ?? 'info';
    unset($_SESSION['message'], $_SESSION['message_code']);

    if ($flash === 'Unauthenticated! Please log in!') {
        echo '<script>window.location.href = "/login";</script>';
        return;
    }
    ?>
    <div id="flashMessage" class="alert alert-<?= $flashType ?> alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3 shadow"
        role="alert" style="z-index: 1080; min-width: 280px; max-width: 90vw;">
        <?= htmlspecialchars($flash) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <script>
        setTimeout(function () {
            var el = document.getElementById('flashMessage');
            if (el) { el.classList.remove('show'); setTimeout(function () { el.remove(); }, 300); }
        }, 5000);
    </script>
    <?php
}
