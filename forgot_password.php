<?php
session_start();
$title = "Forgot Password | KV Dental Clinic";
include('includes/header.php');
?>
<section style="background-image: url('img/dummy_img_1.png') !important; background-repeat: no-repeat !important; background-attachment: fixed; background-position: center; background-size: cover;">
    <div class="container mt-5" style="width: 35%;">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-12 col-sm-12">
                <div class="card text-black">
                    <div class="card-header text-center" style="background-color: var(--first-color);">
                        <h4 class="text-white" style="letter-spacing: 5px; font-size: 20pt;">Forgot Password</h4>
                    </div>
                    <div class="card-body">
                        <form action="functions/forgot_password_process.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label"><small><i class="fa-solid fa-at"></i>Enter your email address</label></small>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" name="forgot_password_btn" class="btn btn-primary btn-sm text-center">Send Reset Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>