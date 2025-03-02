<?php
    include('config/dbcon.php');
    function getAllAvailableItems($tbl_items){
        global $con;
        $q = "SELECT * FROM $tbl_items";
        return $q = mysqli_query($con, $q);
    }

    function error($url, $error_message){
        $_SESSION['error_message'] =  $error_message;
        header('Location:' . $url);
        exit();
    }
?>