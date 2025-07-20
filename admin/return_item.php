<?php
header('Content-Type: application/json');
session_start();
include '../config/dbcon.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $borrow_id = intval($_POST['id']);
    $approved_by = $_SESSION['auth_user']['user_id'];

    $query = "SELECT * FROM tbl_borrowed_items WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $borrow_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $student_name = $row['student_name'];
        $section = $row['section'];
        $borrowed_date = $row['borrowed_date'];
        $return_date = $row['return_date'];
        $item_id = intval($row['item_name']);
        $qty = intval($row['qty']);

        $stockQuery = "SELECT stock FROM tbl_items WHERE id = ?";
        $stockStmt = mysqli_prepare($con, $stockQuery);
        mysqli_stmt_bind_param($stockStmt, "i", $item_id);
        mysqli_stmt_execute($stockStmt);
        $stockResult = mysqli_stmt_get_result($stockStmt);

        if ($stockResult && mysqli_num_rows($stockResult) > 0) {
            $stockRow = mysqli_fetch_assoc($stockResult);
            $current_stock = intval($stockRow['stock']);
            $new_stock = $current_stock + $qty;

            $updateStockQuery = "UPDATE tbl_items SET stock = ? WHERE id = ?";
            $updateStockStmt = mysqli_prepare($con, $updateStockQuery);
            mysqli_stmt_bind_param($updateStockStmt, "ii", $new_stock, $item_id);

            if (mysqli_stmt_execute($updateStockStmt)) {
                $insertHistoryQuery = "INSERT INTO tbl_borrowed_history (student_name, section, borrowed_date, return_date, item_name, qty, approved_by) 
                                       VALUES (?, ?, ?, ?, ?, ?, ?)";
                $historyStmt = mysqli_prepare($con, $insertHistoryQuery);
                mysqli_stmt_bind_param($historyStmt, "ssssiii", $student_name, $section, $borrowed_date, $return_date, $item_id, $qty, $approved_by);

                if (mysqli_stmt_execute($historyStmt)) {
                    $deleteQuery = "DELETE FROM tbl_borrowed_items WHERE id = ?";
                    $deleteStmt = mysqli_prepare($con, $deleteQuery);
                    mysqli_stmt_bind_param($deleteStmt, "i", $borrow_id);

                    if (mysqli_stmt_execute($deleteStmt)) {
                        echo json_encode(["status" => "success", "message" => "Item approved and returned successfully!"]);
                        exit;
                    } else {
                        echo json_encode(["status" => "error", "message" => "Error deleting borrowed record."]);
                        exit;
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Error moving record to history."]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Error updating stock."]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Item not found in stock."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Borrowed item not found."]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
    exit;
}
mysqli_close($con);