<?php
include '../config/dbcon.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = mysqli_real_escape_string($con, $_POST['student_name']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $borrowed_date = mysqli_real_escape_string($con, $_POST['borrowed_date']);
    $return_date = mysqli_real_escape_string($con, $_POST['return_date']);
    $item_id = intval($_POST['item']);
    $qty = intval($_POST['qty']);

    // Get current stock
    $query = "SELECT stock FROM tbl_items WHERE id = $item_id";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_stock = intval($row['stock']);

        if ($qty > 0 && $qty <= $current_stock) {
            $insertQuery = "INSERT INTO tbl_borrowed_items (student_name, section, borrowed_date, return_date, item_name, qty) 
                            VALUES ('$student_name', '$section', '$borrowed_date', '$return_date', '$item_id', '$qty')";
            if (mysqli_query($con, $insertQuery)) {
                // Deduct quantity from stock
                $new_stock = $current_stock - $qty;
                $updateStockQuery = "UPDATE tbl_items SET stock = $new_stock WHERE id = $item_id";
                if (mysqli_query($con, $updateStockQuery)) {
                    echo json_encode(['success' => true, 'message' => 'Borrowing record added successfully!']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating stock.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error inserting data into borrowed items.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid quantity.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Item not found.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

mysqli_close($con);
?>
