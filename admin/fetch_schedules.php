<?php
include('../config/dbcon.php');

$query = "SELECT 
            s.id, 
            s.title, 
            s.section, 
            s.subject, 
            s.date, 
            s.start, 
            s.end, 
            s.user_id, 
            u.name 
          FROM tbl_schedules s
          INNER JOIN tbl_users u ON s.user_id = u.id";

$result = mysqli_query($con, $query);

$schedules = [];

$colors = [
    1 => "#FF5733", // User 1: Red-orange
    2 => "#33FF57", // User 2: Green
    53 => "#3357FF", // User 3: Blue
    54 => "#FF33A6", // User 4: Pink
    5 => "#FFA533", // User 5: Orange
];

while ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['user_id'];
    $eventColor = isset($colors[$user_id]) ? $colors[$user_id] : "#cccccc"; 

    $schedules[] = [
        'id' => $row['id'],
        'title' => $row['title'] . " - " . $row['subject'] . " (" . $row['section'] . ")",
        'start' => $row['date'] . "T" . $row['start'], 
        'end' => $row['date'] . "T" . $row['end'],
        'backgroundColor' => $eventColor,
        'borderColor' => $eventColor, 
        'extendedProps' => [
            'name' => $row['name']
        ]
    ];
}

echo json_encode($schedules);
?>
