<?php

require 'config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['class_id']) && isset($_POST['lesson_id']) && isset($_POST['file_id'])) {
        $classID = $_POST['class_id'];
        $lessonID = $_POST['lesson_id'];
        $fileID = $_POST['file_id'];

        // Delete the lesson file
        $deleteFileQuery = "DELETE FROM lesson_files WHERE lesson_id = '$lessonID' AND file_id = '$fileID'";
        if (mysqli_query($connection, $deleteFileQuery)) {
            // File deletion successful
            $filePath = "uploads/" . $fileID; // Update this with your file path
            if (file_exists($filePath)) {
                unlink($filePath); // Delete the physical file
            }

            $response = ['status' => 'success', 'message' => 'File deleted successfully.'];
            echo json_encode($response);
        } else {
            // File deletion failed
            $response = ['status' => 'error', 'message' => 'Error deleting file: ' . mysqli_error($connection)];
            echo json_encode($response);
        }

        mysqli_close($connection);
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid parameters.'];
        echo json_encode($response);
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request method.'];
    echo json_encode($response);
}
?>
