<?php
session_start();
$title = "Reset Password | KV Dental Clinic";
include('includes/header.php');
include('config/dbcon.php');
?>
<section style="background-image: url('img/dummy_img_1.png') !important; background-repeat: no-repeat !important; background-attachment: fixed; background-position: center; background-size: cover;">
    <div class="container mt-5" style="width: 35%;">
        <div class="row min-vh-100 align-items-center">
            <div class="col-lg-12 col-sm-12">
                <div class="card text-black">
                    <div class="card-header text-center" style="background-color: var(--first-color);">
                        <h4 class="text-white" style="letter-spacing: 5px; font-size: 20pt;">Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <?php
                            if (isset($_GET['token']) && isset($_GET['email'])) {
                                $token = $_GET['token'];
                                $email = $_GET['email'];

                                $query = "SELECT * FROM tbl_users WHERE email='$email' AND reset_token='$token' AND reset_token_expire >= NOW() LIMIT 1";
                                $query_run = mysqli_query($con, $query);

                                if (mysqli_num_rows($query_run) > 0) {
                                ?>
                                    <form action="functions/reset_password_process.php" method="POST">
                                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                                        <div class="mb-3">
                                            <label class="form-label"><small><i class="fa-solid fa-key"></i> New Password</label></small>
                                            <input type="password" name="new_password" class="form-control" required minlength="8" maxlength="16" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[#?!]).{8,16}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><small><i class="fa-solid fa-key"></i> Confirm Password</label></small>
                                            <input type="password" name="confirm_password" class="form-control" required minlength="8" maxlength="16" pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[#?!]).{8,16}">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="reset_password_btn" class="btn btn-primary btn-sm text-center">Reset Password</button>
                                        </div>
                                    </form>
                                <?php
                            } else {
                                echo "<p class='text-danger text-center'>Invalid or expired token.</p>";
                            }
                        } else {
                            echo "<p class='text-danger text-center'>Invalid request.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>