<?php
include('../config/dbcon.php');
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['auth_user']['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['auth_user']['user_id'];

if (isset($_POST['id'])) {
    $schedule_id = mysqli_real_escape_string($con, $_POST['id']);

    $query = "SELECT * FROM tbl_schedules WHERE id = '$schedule_id' AND user_id = '$user_id' LIMIT 1";
    $result = mysqli_query($con, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "id" => $row['id'],
                "title" => $row['title'],
                "section" => $row['section'],
                "subject" => $row['subject'],
                "date" => $row['date'],
                "start" => date("Y-m-d\TH:i", strtotime($row['start'])), 
                "end" => date("Y-m-d\TH:i", strtotime($row['end'])) 
            ]
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Unauthorized access"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}
