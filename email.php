<?php
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendAppointmentConfirmationEmail($email, $appointment_date, $service, $patient_name, $time_labels)
{
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'lloydlanguido@gmail.com'; 
    $mail->Password = 'dhwe dmpx tokt uphu'; // password for api emails acc
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('lloydlanguido@gmail.com', 'KV Dental Clinic'); // Palitan to ng existing email
    $mail->addAddress($email);

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Appointment Booked Successfully - KV Dental Clinic';
    $mail->Body = '
        <div style="text-align: justify; font-family: Arial, sans-serif;">
          <h2>Dear ' . $patient_name . ',</h2>
          <p>We are pleased to inform you that your appointment has been successfully booked.</p>
          <h4>Appointment Details:</h4>
          <ul>
            <li><strong>Date:</strong> ' . $appointment_date . '</li>
            <li><strong>Time:</strong> ' . $time_labels . '</li>
            <li><strong>Service:</strong> ' . $service . '</li>
          </ul>  
          <p>If you have any questions or require further information, please do not hesitate to contact KV Dental Clinic.</p>
          <p>Best regards, <strong>KV Dental Clinic.</strong></p>
        </div>
      ';

    $mail->send();
    return true;
  } catch (Exception $e) {
    return false;
  }
}

include('config/dbcon.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Fetch
  $timeSlot = mysqli_real_escape_string($con, $_POST['timeSlot']);
  $appointment_date = mysqli_real_escape_string($con, $_POST['appointment_date']);
  $hmo = mysqli_real_escape_string($con, $_POST['hmo']);
  $service = mysqli_real_escape_string($con, $_POST['service']);
  $patient_name = mysqli_real_escape_string($con, $_POST['patient_name']);
  $age = mysqli_real_escape_string($con, $_POST['age']);
  $gender = mysqli_real_escape_string($con, $_POST['gender']);
  $email = mysqli_real_escape_string($con, $_POST['email']);
  $phone = mysqli_real_escape_string($con, $_POST['phone']);
  $address = mysqli_real_escape_string($con, $_POST['address']);
  $dob = mysqli_real_escape_string($con, $_POST['dob']);

  $emailValid = false;

  if (!empty($email)) {
    $apiKey = 'bb534a39c343470a98d4ae86e4f4c4ea'; // API KEY for abstract 
    $url = 'https://emailvalidation.abstractapi.com/v1/?api_key=' . $apiKey . '&email=' . urlencode($email); // ABSTARCT API pang check ng email 

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    $result = json_decode($response, true);
    $emailValid = isset($result['deliverability']) && $result['deliverability'] === 'DELIVERABLE' && strpos($email, '@gmail.com') !== false;
  }

  if ($emailValid) {
    $emailCheckStmt = $con->prepare("SELECT COUNT(*) FROM tbl_appointments WHERE email = ?");
    $emailCheckStmt->bind_param("s", $email);
    $emailCheckStmt->execute();
    $emailCheckStmt->bind_result($emailCount);
    $emailCheckStmt->fetch();
    $emailCheckStmt->close();

    if ($emailCount > 0) {
      echo json_encode(array("success" => false, "message" => "This email is already associated with an appointment."));
      exit;
    }
  } elseif (!empty($email)) {
    echo json_encode(array("success" => false, "message" => "Provided email is not a valid Gmail address."));
    exit;
  }

  // FETCH TIME LABELS
  $stmt = $con->prepare("SELECT time_labels FROM tbl_timeslots WHERE id = ?");
  $stmt->bind_param("i", $timeSlot);
  $stmt->execute();
  $stmt->bind_result($time_labels);
  $stmt->fetch();
  $stmt->close();

  $appointment = $con->prepare("
        INSERT INTO 
            tbl_appointments (timeSlot, appointment_date, hmo, service, patient_name, age, gender, email, phone, address, dob) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

  $appointment->bind_param(
    "sssssssssss",
    $timeSlot,
    $appointment_date,
    $hmo,
    $service,
    $patient_name,
    $age,
    $gender,
    $email,
    $phone,
    $address,
    $dob
  );

  if ($appointment->execute()) {
    if ($emailValid) {
      if (sendAppointmentConfirmationEmail($email, $appointment_date, $service, $patient_name, $time_labels)) {
        echo json_encode(array("success" => true, "message" => "Appointment scheduled successfully! Email sent."));
      } else {
        echo json_encode(array("success" => true, "message" => "Appointment scheduled successfully! Email not sent."));
      }
    } else {
      echo json_encode(array("success" => true, "message" => "Appointment scheduled successfully! No email provided."));
    }
  } else {
    echo json_encode(array("success" => false, "message" => "Error scheduling appointment: " . $con->error));
  }

  $appointment->close();
  $con->close();
  exit;
}
