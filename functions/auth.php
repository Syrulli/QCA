<?php
session_start();
include('../config/dbcon.php');
include('./myfunction.php');

// // if btn clicked / true
// Register btn (register.php)
if (isset($_POST['register_btn'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);

    $check_email_query = "SELECT email FROM tbl_users WHERE email=?";
    $stmt = mysqli_prepare($con, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['message'] = "Email already registered";
        header('Location: ../register.php');
        exit();
    } else {
        if ($password === $cpassword) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

            $insert_query = "INSERT INTO tbl_users (name, email, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "sss", $name, $email, $hashed_password);
            $query_run = mysqli_stmt_execute($stmt);

            if ($query_run) {
                $_SESSION['message'] = "Registered Successfully";
                header('Location: ../index.php');
                exit();
            } else {
                $_SESSION['message'] = "Something went wrong";
                header('Location: ../register.php');
                exit();
            }
        } else {
            $_SESSION['message'] = "Passwords do not match";
            header('Location: ../register.php');
            exit();
        }
    }
}

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $login_query = "SELECT * FROM tbl_users WHERE email=?";
    $stmt = mysqli_prepare($con, $login_query);
    mysqli_stmt_bind_param($stmt, "s", $email); 
    mysqli_stmt_execute($stmt);
    $login_query_run = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($login_query_run) > 0) {
        $userdata = mysqli_fetch_array($login_query_run);
        $hashed_password = $userdata['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['auth'] = true;

            $userid = $userdata['id'];
            $username = $userdata['name'];
            $useremail = $userdata['email'];
            $role_as = $userdata['role_as'];

            $_SESSION['auth_user'] = [
                'user_id' => $userid,
                'name' => $username,
                'email' => $useremail
            ];

            // ACCESS LEVEL 
            $_SESSION['role_as'] = $role_as;
            if ($role_as == 1) {
                redirect("../admin/index.php", "Welcome To Dashboard");
            } 
        } else {
            error("../index.php", "Invalid Credentials");
        }
    } else {
        error("../index.php", "Invalid Credentials");
    }
}
?>