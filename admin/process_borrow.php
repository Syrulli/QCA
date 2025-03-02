<?php
require '../config/dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $qty = mysqli_real_escape_string($con, $_POST['qty']);
    $borrowed_date = mysqli_real_escape_string($con, $_POST['borrowed_date']);
    $return_date = mysqli_real_escape_string($con, $_POST['return_date']);
    $item_name = mysqli_real_escape_string($con, $_POST['item']); 

    $borrower = $con->prepare("
          INSERT INTO tbl_borrower (student_name, section, qty, borrowed_date, return_date, item_name) 
          VALUES (?, ?, ?, ?, ?, ?)");

    if ($borrower === false) {
        die(json_encode(["success" => false, "message" => "Database error: " . $con->error]));
    }

    $borrower->bind_param("ssisss", $student_name, $section, $qty, $borrowed_date, $return_date, $item_name);

    if ($borrower->execute()) {
        echo json_encode(["success" => true, "message" => "Borrow request submitted successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $borrower->error]);
    }

    $borrower->close();
    $con->close();
    exit;
}
?>
