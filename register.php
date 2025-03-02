<?php
  session_start();
  $title = "Create Account | KV Dental";
  if (isset($_SESSION['auth'])) {
    $_SESSION['message'] = "You already have account";
    header('Location: admin/index.php');
    exit();
  }
  include('includes/header.php');
?>
<section style="background-image: url('img/dummy_img_1.png') !important; background-repeat: no-repeat !important; background-attachment: fixed; background-position: center; background-size: cover;">
  <div class="container mt-5" style="width: 50%;">
    <div class="row min-vh-100 align-items-center">
      <div class="col-lg-12 col-sm-12">
        <?php
        if (isset($_SESSION['message'])) { ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?= $_SESSION['message']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php
          unset($_SESSION['message']);
        }
        ?>
        <div class="card" style="background-color: var(--section);">
          <div class="card-header text-center" style="background-color: var(--first-color);">
            <h4 class="text-white" style="letter-spacing: 3px; font-size: 20pt;">Create an Account</h4>
          </div>
          <div class="card text-black">
            <form action="functions/auth.php" method="POST">
              <div class="row px-3 mt-lg-3">
                <div class="container col-6">
                  <div class="mb-3">
                    <label class="form-label"><small>Full Name</small></label>
                    <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><small>Email address</small></label>
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                  </div>
                </div>
                <div class="container col-6">
                  <div class="mb-3">
                    <label class="form-label"><small>Password</small></label>
                    <div class="input-group">
                      <input type="password" name="password" id="password" placeholder="Password" class="form-control" required>
                      <!-- minlength="8" maxlength="16"  -->
                      <button type="button" class="btn btn-outline-primary" onclick="togglePasswordVisibility()">
                        <i class="fa-solid fa-eye"></i>
                      </button>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label"><small>Confirm Password</small></label>
                    <input type="password" name="cpassword" placeholder="Confirm password" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="text-center mb-3">
                <button type="submit" name="register_btn" class="btn btn-outline-primary btn-sm">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>