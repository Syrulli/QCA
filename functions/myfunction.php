<?php 
    session_start();
    include('../config/dbcon.php');
    
    function updateAcc(){
        global $con;
        $userId = $_SESSION['auth_user']['user_id'];
        $q = "SELECT * FROM tbl_users WHERE id= '$userId' ";
        return $q = mysqli_query($con, $q);
    }

    function getAllBorrowedHistory() {
        global $con;
        $query = "SELECT h.*, 
                         i.item_name AS item_name, 
                         u.name AS approved_by 
                  FROM tbl_borrowed_history h
                  JOIN tbl_items i ON h.item_name = i.id
                  JOIN tbl_users u ON h.approved_by = u.id
                  ORDER BY h.return_date DESC";
        
        $result = mysqli_query($con, $query);
        $borrowedHistory = [];
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                $borrowedHistory[] = $row;
            }
        }
        return $borrowedHistory;
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

    function getAllBorrower(){
        global $con;
        $q = "SELECT 
                b.id AS borrow_id,
                b.student_name,
                b.section,
                b.borrowed_date,
                b.return_date,
                i.item_name,
                b.qty AS total_item
              FROM tbl_borrowed_items b
              JOIN tbl_items i ON b.item_name = i.id
              ORDER BY b.borrowed_date DESC";
    
        $result = mysqli_query($con, $q);
        
        if (!$result) {
            die("Query Failed: " . mysqli_error($con));
        }
    
        $borrowers = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $borrowers[] = $row;
        }
    
        return $borrowers; 
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