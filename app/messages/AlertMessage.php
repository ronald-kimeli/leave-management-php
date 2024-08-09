<?php

namespace app\messages;
class AlertMessage {
    public static function display() {
        if (isset($_SESSION['message']) && isset($_SESSION['message_code'])) {
            $message = $_SESSION['message'];
            $message_code = $_SESSION['message_code'];
            ?>
            <div id="alertMessage" class="alert alert-<?= $message_code ?> alert-dismissible fade show" role="alert" style="transition: opacity 1s ease;">
                <?= $message ?> .
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                setTimeout(function() {
                    var alertMessage = document.getElementById('alertMessage');
                    if (alertMessage) {
                        alertMessage.style.opacity = '0';
                        setTimeout(function() {
                            alertMessage.remove();
                        }, 1000); // Fading duration
                    }
                }, 2000); // 1000 milliseconds = 1 second 
            </script>
            <?php
            unset($_SESSION['message']);
            unset($_SESSION['message_code']);
        }
    }
}
?>
