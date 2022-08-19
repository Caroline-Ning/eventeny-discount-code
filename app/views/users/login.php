<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row small">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <?php flash('register_success') ?>
      <h5>Log In</h5>
      <form action="<?php echo URLROOT; ?>/users/login" method="post">
        <div class="form-group mb-3 mt-3">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control form-control-sm <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
        </div>
        <div class="form-group mb-4">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control form-control-sm <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>

        <div class="row">
          <div class="col">
            <input type="submit" value="Login" class="btn btn-outline-primary">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT; ?>/users/register" class="btn">No account? Register</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>