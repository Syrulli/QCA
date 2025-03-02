<?php
    include('../config/dbcon.php');
    include('../functions/myfunction.php');

    // UPDATE ACC FUNCTIONS
        if (isset($_POST['update_acc_btn'])) {
            $modal_update_acc = $_POST['modal_update_acc'];
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $password = mysqli_real_escape_string($con, $_POST['password']);
        
            if (!empty($password)) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $password_query = ", password='$hashed_password'";
            } else {
                $password_query = ""; 
            }
        
            $update_query = "UPDATE tbl_users SET 
                name='$name', 
                email='$email'
                $password_query
                WHERE id='$modal_update_acc'";
        
            $update_query_run = mysqli_query($con, $update_query);
        
            if ($update_query_run) {
                redirect("index.php?id=$modal_update_acc", "Account Updated Successfully!");
            } else {
                error("index.php?id=$modal_update_acc", "Something Went Wrong!");
            }
        }
    // UPDATE ACC FUNCTIONS

    // ADD SCHEDULE
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === "add_schedule") {
            if (!isset($_POST['user_id']) || empty($_POST['user_id'])) {
                echo json_encode(["status" => "error", "message" => "ERROR: user_id is missing."]);
                exit();
            }
        
            $user_id = $_POST['user_id'];
            $title = $_POST['title'];
            $section = $_POST['section'];
            $subject = $_POST['subject'];
            $date = $_POST['date'];
            $start = $_POST['start'];
            $end = $_POST['end'];
        
            $stmt = $con->prepare("SELECT COUNT(*) FROM tbl_schedules WHERE date = ? AND ((start <= ? AND end > ?) OR (start < ? AND end >= ?))");
            $stmt->bind_param("sssss", $date, $start, $start, $end, $end);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
        
            if ($count > 0) {
                echo json_encode(["status" => "error", "message" => "The date and time is not available."]);
                exit();
            }
        
            $stmt = $con->prepare("INSERT INTO tbl_schedules (user_id, title, section, subject, date, start, end) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $user_id, $title, $section, $subject, $date, $start, $end);
        
            if ($stmt->execute()) {
                $stmt->close();
                echo json_encode(["status" => "success", "message" => "Schedule Successfully Added!"]);
                exit();

            } else {
                echo json_encode(["status" => "error", "message" => "Failed to add schedule."]);
                exit();
            }
        
            $stmt->close();
        }
    // ADD  SCHEDULE

    // ADD ITEM FUNCTIONS
        if (isset($_POST['add_item_btn'])) {
            $item_name = trim($_POST['item_name']);
            $stock = trim($_POST['stock']);
            $image = $_FILES['image']['name'];
            $path = "../uploaded";
            $image_ext = pathinfo($image, PATHINFO_EXTENSION);
            $filename = time() . '.' . $image_ext;
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            if (!in_array($image_ext, $allowed_extensions)) {
                redirect("inventory.php", "Invalid image file type");
                exit();
            }
        
            $stmt = $con->prepare("INSERT INTO tbl_items (item_name, stock, image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $item_name, $stock, $filename);
        
            if ($stmt->execute()) {
                $stmt->close();
                move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
                redirect("inventory.php", "Item Added Successfully");
            } else {
                $stmt->close();
                error("inventory.php", "Something Went Wrong");
                exit();
            }
        }
    // ADD ITEM FUNCTIONS

    // UPDATE  SCHEDULE
        if (isset($_POST['update_schedule_btn'])) {
            if (!isset($_SESSION['auth_user']['user_id'])) {
                $_SESSION['status'] = "Unauthorized access!";
                header("Location: schedule.php");
                exit();
            }
        
            $schedule_id = mysqli_real_escape_string($con, $_POST['id']);
            $title = mysqli_real_escape_string($con, $_POST['title']);
            $section = mysqli_real_escape_string($con, $_POST['section']);
            $subject = mysqli_real_escape_string($con, $_POST['subject']);
            $date = mysqli_real_escape_string($con, $_POST['date']);
            $start = mysqli_real_escape_string($con, $_POST['start']);
            $end = mysqli_real_escape_string($con, $_POST['end']);
            $user_id = $_SESSION['auth_user']['user_id'];
        
            $check_query = "SELECT user_id FROM tbl_schedules WHERE id = '$schedule_id' LIMIT 1";
            $check_result = mysqli_query($con, $check_query);
        
            if ($check_result && mysqli_num_rows($check_result) > 0) {
                $row = mysqli_fetch_assoc($check_result);
        
                if ($row['user_id'] == $user_id) {
                    $query = "UPDATE tbl_schedules SET title='$title', section='$section', subject='$subject', date='$date', start='$start', end='$end' WHERE id='$schedule_id' AND user_id='$user_id'";
                    $result = mysqli_query($con, $query);
        
                    if ($result) {
                        $_SESSION['status'] = "Schedule updated successfully!";
                        header("Location: schedules.php");
                        exit();
                    } else {
                        $_SESSION['status'] = "Error updating schedule.";
                        header("Location: schedules.php");
                        exit();
                    }
                } else {
                    $_SESSION['status'] = "Unauthorized: You can't edit this schedule.";
                    header("Location: schedules.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Schedule not found.";
                header("Location: schedules.php");
                exit();
            }
        }
    //  UPDATE  SCHEDULE

    // UPDATE ITEMS FUNCTIONS 
        if (isset($_POST['update_item_btn'])) {
            $tbl_item_id = $_POST['tbl_item_id'];
            $item_name = $_POST['item_name'];
            $stock = $_POST['stock'];
            $new_image = $_FILES['image']['name'];
            $old_image = $_POST['old_image'];

            if ($new_image != "") {
                $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
                $update_filename = time() . '.' . $image_ext;
            } else {
                $update_filename = $old_image;
            }
            $path = "../uploaded";

            $update_query = "UPDATE tbl_items SET 
                    item_name='$item_name', 
                    stock='$stock', 
                    image='$update_filename' 

                WHERE id='$tbl_item_id' 
            ";
            $update_query_run = mysqli_query($con, $update_query);

            if ($update_query_run){
                if ($_FILES['image']['name'] != ""){
                    move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);
                    if (file_exists("../uploaded/" . $old_image)){
                        unlink("../uploaded/" . $old_image);
                    }
                }
                redirect("inventory.php?id=$tbl_item_id", "Tagged Tool Updated Successfully!");
            }else{
                http_response_code(500);
                error("inventory.php?id=$tbl_item_id", "Something went wrong!");
            }
        }
    // UPDATE ITEMS FUNCTIONS

    //  DELETE  SCHEDULE
        if (isset($_POST['delete_schedule']) && isset($_POST['id'])) {    
            $id = mysqli_real_escape_string($con, $_POST['id']);

            $query = "DELETE FROM tbl_schedules WHERE id = '$id'";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Schedule deleted successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to delete schedule."]);
            }
            exit();
        }
    //  DELETE  SCHEDULE

    // DELETE BLOG FUNCTIONS
        else if(isset($_POST['delete_item_btn'])){
            $tbl_item_id = mysqli_real_escape_string($con, $_POST['tbl_item_id']);
            
            $tbl_item_query = "SELECT * FROM tbl_items WHERE id='$tbl_item_id' ";
            $tbl_item_query_run = mysqli_query($con, $tbl_item_query);

            if(mysqli_num_rows($tbl_item_query_run) > 0) {
                $delete_query = "DELETE FROM tbl_items WHERE id='$tbl_item_id' ";
                $delete_query_run = mysqli_query($con, $delete_query);

                if($delete_query_run){
                    echo 200;
                } else {
                    echo 500;
                }
            }
        }
    // DELETE BLOG FUNCTIONS


    else{
        header('Location: ../index.php');
    }
?> 