<?php 
    include('../functions/myfunction.php');
    if(isset($_SESSION['auth'])){
        if($_SESSION['role_as'] != 1){
            error("../index.php", "You are not authorize to access this page");
        }
    }else{
        error("../index.php", "You are not authorize to access this page");
    }
?>