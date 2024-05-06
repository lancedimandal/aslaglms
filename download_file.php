<?php
// Assuming you have already connected to your database here.
require 'config/connection.php';

if (isset($_GET['file'])) {
    // Get the file name from the query parameter and decode it if necessary
    $file_name = urldecode($_GET['file']);
    $file_path = 'activity_file/' . $file_name;

    if (file_exists($file_path)) {
      // Stop further output
    } else {
        // Display a message if the file does not exist
        echo 'File Not Found';
    }
} else {
    // Display a message if the file parameter is not provided
    echo 'Invalid File Request';
}
?>
