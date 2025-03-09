<?php
session_start();
include('../config/dbcon.php');

require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php'; 
require '../PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['forgot_password_btn'])) {

    $email = mysqli_real_escape_string($con, $_POST['email']);

    $query = "SELECT * FROM tbl_users WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_array($result);
        $token = bin2hex(random_bytes(20));
        $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d")+1, date("Y"));
        $expDate = date("Y-m-d H:i:s", $expFormat);

        $update_query = "UPDATE tbl_users SET reset_token=?, reset_token_expire=? WHERE email=?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "sss", $token, $expDate, $email);
        $update_query_run = mysqli_stmt_execute($stmt);

        if ($update_query_run) {
            $reset_link = "http://localhost/QCA/reset_password.php?token=$token&email=$email"; // FOR LOCAL 

        //    $reset_link = " https://qca.online/reset_password.php?token=$token&email=$email"; // FOR HOSTED
           
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'andremanebo@gmail.com';
                $mail->Password   = 'zjkv qvud savy hmmj'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('', 'Quezon City Academy');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "Hi,<br><br>Click the link below to reset your password:<br><br>
                                <a href='$reset_link'>Reset Password</a><br><br>If you did not request this, please ignore this email.";

                $mail->send();
                $_SESSION['status'] = "Password reset link has been sent to your email.";
                header('Location: ../login.php');
                exit(0);
            } catch (Exception $e) {
                $_SESSION['status'] = "Failed to send email. Please try again.";
                header('Location: ../forgot_password.php');
                exit(0);
            }
        } else {
            $_SESSION['status'] = "Something went wrong. Please try again.";
            header('Location: ../forgot_password.php');
            exit(0);
        }
    } else {
        $_SESSION['status'] = "Email address not found.";
        header('Location: ../forgot_password.php');
        exit(0);
    }
} else {
    header('Location: ../login.php');
    exit(0);
}
?>
