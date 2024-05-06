<?php
require_once 'config/connection.php';

// Check if the exam ID is provided in the query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Invalid or missing exam ID
    // Return a JSON response with an error message
    $response = array('status' => 'error', 'message' => 'Invalid Announcement ID');
    echo json_encode($response);
    exit;
}

// Get the exam ID from the query string
$announcement_id = $_GET['id'];

// Prepare the deletion query with parameter binding
$sqlDelete = "DELETE FROM announcements WHERE announcement_id = ?";

// Create a prepared statement
$stmt = mysqli_prepare($connection, $sqlDelete);

// Bind the parameter
mysqli_stmt_bind_param($stmt, "i", $announcement_id);

// Execute the deletion query
if (mysqli_stmt_execute($stmt)) {
    // Deletion was successful
    // Return a JSON response with a success message
    $response = array('status' => 'success', 'message' => 'Announcement Deleted Successfully');
    echo json_encode($response);
} else {
    // Deletion failed
    // Return a JSON response with an error message
    $response = array('status' => 'error', 'message' => 'Announcement Deletion Failed:');
    echo json_encode($response);
}

// Close the prepared statement
mysqli_stmt_close($stmt);
?>
