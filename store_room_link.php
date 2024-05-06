<?php
require_once('config/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $classId = $_POST['classId'];
    $roomName = $_POST['roomName'];
    $scheduledTimeInput = $_POST['scheduledTime']; // Input scheduled time in format 'Y-m-d H:i'

    // Convert input scheduled time to a DateTime object in the desired timezone (Asia/Manila)
    $timezone = new DateTimeZone('Asia/Manila');
    $scheduledTime = new DateTime($scheduledTimeInput, $timezone);

    // Add 8 hours to the scheduled time
    $scheduledTime->modify('+8 hours');

    try {
        // Insert data into the room_links table
        $sql = "INSERT INTO room_links (class_id, room_name, scheduled_time, created_at)
                VALUES (?, ?, ?, NOW())";
        $stmt = $connection->prepare($sql);

        // Bind parameters and execute
        $formattedScheduledTime = $scheduledTime->format('Y-m-d H:i:s');
        $stmt->bind_param("iss", $classId, $roomName, $formattedScheduledTime);
        $stmt->execute();

        echo "Room link scheduled and stored successfully!";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
