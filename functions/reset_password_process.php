<?php
session_start();
include('../config/dbcon.php');

if (isset($_POST['reset_password_btn'])) {
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $token = mysqli_real_escape_string($con, $_POST['token']);
  $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
  $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

  if ($new_password === $confirm_password) {
    // Check if the token is valid and not expired
    $query = "SELECT reset_token_expire FROM tbl_users WHERE email=? AND reset_token=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "ss", $email, $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
      $reset_token_expire = $row['reset_token_expire'];
      if (strtotime($reset_token_expire) > time()) { // Token is still valid
        // Hash the new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_query = "UPDATE tbl_users SET password=?, reset_token=NULL, reset_token_expire=NULL WHERE email=? AND reset_token=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sss", $hashed_password, $email, $token);
        if (mysqli_stmt_execute($stmt)) {
          $_SESSION['status'] = "Password has been reset successfully.";
          header('Location: ../login.php');
          exit();
        } else {
          $_SESSION['status'] = "Failed to reset password. Please try again.";
          header('Location: ../reset_password.php?token=' . urlencode($token) . '&email=' . urlencode($email));
          exit();
        }
      } else {
        $_SESSION['status'] = "Reset token has expired.";
        header('Location: ../reset_password.php?token=' . urlencode($token) . '&email=' . urlencode($email));
        exit();
      }
    } else {
      $_SESSION['status'] = "Invalid reset token.";
      header('Location: ../reset_password.php?token=' . urlencode($token) . '&email=' . urlencode($email));
      exit();
    }
  } else {
    $_SESSION['status'] = "Passwords do not match.";
    header('Location: ../reset_password.php?token=' . urlencode($token) . '&email=' . urlencode($email));
    exit();
  }
} else {
  header('Location: ../login.php');
  exit();
}
