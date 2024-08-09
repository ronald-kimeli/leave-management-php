<?php

if (isset($_SESSION['message'])) {
  ?>
<script src="/views/assets/frontend/js/sweetalert.min.js"></script>
<script>
swal({
  title: "<?= $_SESSION['message'] ?>!",
  text: "",
  icon: "<?= $_SESSION['message_code'] ?>",
  button: "Ok Done!",
});
</script>
<?php
  unset($_SESSION['message']);
}

?>