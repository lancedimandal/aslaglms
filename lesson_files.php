<?php
require_once 'config/connection.php';

if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Retrieve the files for the specified class ID
    $selectQuery = "SELECT * FROM lessons WHERE class_id = ?";
    $stmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $classID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $files = array();
    if (mysqli_num_rows($result) > 0) {
        // Fetch the files and store them in an array
        while ($lesson = mysqli_fetch_assoc($result)) {
            $files[] = array(
                'lesson_title' => $lesson['lesson_title'],
                'lesson_description' => $lesson['lesson_description'],
                'lesson_image' => $lesson['lesson_image'],
                'file_url' => $lesson['file_url'],
            );
        }
    }

    // Return the files as JSON response
    header('Content-Type: application/json');
    echo json_encode($files);
}
?>
