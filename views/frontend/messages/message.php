<?php
if (isset($_SESSION['message'])) {
    ?>
    <script src="/views/assets/frontend/js/sweetalert.min.js"></script>
    <script>
        if ("<?= $_SESSION['message'] ?>" === "Unauthenticated! Please log in!") {
            window.location.href = "/login";
        } else {
            swal({
                title: "<?= $_SESSION['message'] ?>",
                text: "",
                icon: "<?= isset($_SESSION['message_code']) ? $_SESSION['message_code'] : 'info' ?>", // Default to 'info' if message_code is not set
                button: "Ok Done!",
            });
        }
    </script>
    <?php
    unset($_SESSION['message']);
}
?>
