<?php

if (isset($_POST['logout_btn'])) {
// remove all session variables
session_unset();
// destroy the session
session_destroy();

header("Location: /");
exit(0);
}
?>