<?php 
    session_start();
    include('../config/dbcon.php');
    
    function updateAcc(){
        global $con;
        $userId = $_SESSION['auth_user']['user_id'];
        $q = "SELECT * FROM tbl_users WHERE id= '$userId' ";
        return $q = mysqli_query($con, $q);
    }

    function getAllItems($tbl_items){
        global $con;
        $q = "SELECT * FROM $tbl_items";
        return $q = mysqli_query($con, $q);
    }

    function getAllItemId($tbl_items, $id){
        global $con;
        $q = "SELECT * FROM $tbl_items WHERE id='$id' ";
        return $q = mysqli_query($con, $q);
    }
    
    function redirect($url, $message){
        $_SESSION['message'] =  $message;
        header('Location:' .$url);
        exit();
    }
    function error($url, $error_message){
        $_SESSION['error_message'] =  $error_message;
        header('Location:' .$url);
        exit();
    }
?>