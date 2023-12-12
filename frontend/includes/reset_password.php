<div class="container px-4 py-5 mx-auto">
  <!-- LOGIN -->
  <main id="login">
    <div class="container px-4 py-5 mx-auto">
      <div class="row">
        <div class="col-md-6 mx-auto">
          <?php require __DIR__ . "/../messages/message.php"; ?>
          <div class="auth-form">
            <h4 class="text-center mb-4">Register Account</h4>
            <form method="post" action="/allcode">
              <input type="hidden" name="code" value="<?php echo @$_GET['code']; ?>">
              <label for="new_password">New Password:</label>
              <input type="password" name="new_password" required>
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" name="confirm_password" required>
              <button type="submit" name="reset_password">Reset Password</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>