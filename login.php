<?php
  session_start();
  $title = "Login | QCA";
  if (isset($_SESSION['auth'])) {
    $_SESSION['error_message'] = "You already Logged in";
    header('Location: admin/index.php');
    exit();
  }
  include('includes/header.php');
?>
<section style="background-image: url('img/dummy_img_1.png') !important; background-repeat: no-repeat !important; background-attachment: fixed; background-position: center; background-size: cover;">
  <div class="container mt-5" style="width: 35%;">
    <div class="row min-vh-100 align-items-center">
      <div class="col-lg-12 col-sm-12">
        <div class="card text-black">
          <div class="card-header text-center" style="background-color: var(--first-color);">
            <h4 class="text-white" style="letter-spacing: 5px; font-size: 20pt;">Welcome back</h4>
          </div>
          <div class="card-body">
            <form action="functions/auth.php" method="POST">
              <div class="mb-3">
                <label class="form-label"><small> <i class="fa-solid fa-at"></i> Email address</label></small>
                <input type="email" name="email" class="form-control">
              </div>
              <div class="mb-3">
                <label class="form-label"><small><i class="fa-solid fa-key"></i> Password</label></small>
                <div class="input-group">
                  <input type="password" name="password" id="password" class="form-control">
                  <button type="button" class="btn btn-outline-primary" onclick="togglePasswordVisibility()">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </div>
              </div>
              <div class="text-center mt-2 mb-2">
                <a href="forgot_password.php" class="text-decoration-none"><small>Forgot Password?</small></a>
              </div>
              <div class="text-center">
                <button type="submit" name="login_btn" class="btn btn-primary btn-sm text-center">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php include('includes/footer.php'); ?>