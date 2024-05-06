<?php
require_once 'config/connection.php';

// Retrieve the class ID from the request
$classId = $_POST['class_id'];

// Perform the deletion query
$stmt = $connection->prepare("DELETE FROM classes WHERE class_id = ?");
$stmt->bind_param("s", $classId);

$response = array();

if ($stmt->execute()) {
    // Deletion successful
    $response['success'] = true;
} else {
    // Deletion failed
    $response['success'] = false;
    $response['error'] = "Failed to delete class.";
}

// Close the prepared statement and database connection
$stmt->close();
$connection->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
