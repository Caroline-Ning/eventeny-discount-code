<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row small">
  <div class="col-md-6 mx-auto">
    <div class="card card-body bg-light mt-5">
      <h5>Create An Account</h5>

      <form action="<?php echo URLROOT; ?>/users/register" method="post">

        <div class="form-group mt-3 mb-3">
          <label for="name">Name:</label>
          <input type="text" name="name" class="form-control form-control-sm <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>">

          <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
        </div>

        <div class="form-group mb-3">
          <label for="email">Email:</label>
          <input type="email" name="email" class="form-control form-control-sm <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">

          <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
        </div>

        <div class="form-group mb-3">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control form-control-sm <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">

          <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
        </div>

        <div class="form-group mb-4">
          <label for="confirm_password">Confirm Password:</label>
          <input type="password" name="confirm_password" class="form-control form-control-sm <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">

          <span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
        </div>
        <!-- admin or guest -->
        <div class="form-group mb-4">
          <label for="status" class="me-4">Are you an event organizer?</label>

          <!-- $res = $_POST['status'], $res = "admin" or "guest" -->
          <input type="radio" <?php if ($data['status'] == 'admin') echo "checked" ?> name="status" class="<?php echo (!empty($data['status_err'])) ? 'is-invalid' : ''; ?>" value='admin' />
          <label class="me-2">Yes</label>

          <input type="radio" <?php if ($data['status'] == 'guest') echo "checked" ?> name="status" class="<?php echo (!empty($data['status_err'])) ? 'is-invalid' : ''; ?>" value="guest" />
          <label>No</label>

          <span class="invalid-feedback"><?php echo $data['status_err']; ?></span>
        </div>

        <div class="row">
          <div class="col">
            <input type="submit" value="Sign-up" class="btn btn-outline-primary">
          </div>
          <div class="col">
            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>