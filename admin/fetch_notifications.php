<?php
session_start();
include '../config/dbcon.php';

function getNotifications() {
    global $con;
    $query = "SELECT 
                b.student_name, 
                b.section, 
                i.item_name, 
                b.borrowed_date 
              FROM tbl_borrowed_items b
              JOIN tbl_items i ON b.item_name = i.id
              ORDER BY b.borrowed_date DESC LIMIT 5"; 

    $result = mysqli_query($con, $query);
    $notifications = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;
    }

    return json_encode($notifications);
}

echo getNotifications();
?>
