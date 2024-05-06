<?php
require_once 'config/connection.php';
session_start(); // Start the session

// Check if the teacher ID is set in the session
if (!isset($_SESSION['teacher_idnum'])) {

    echo 'Teacher ID not found. Please log in.';
    exit; // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the teacher ID from the session variable
    $teacherID = $_SESSION['teacher_idnum'];

    // Retrieve the form data
    $className = $_POST['class_name'];
    $subject = $_POST['subject'];
    $schoolYear = $_POST['school_year'];
    $classCode = $_POST['class_code'];
    

     // Process the uploaded image file
     $classImage = null;
     if (isset($_FILES['class_image']) && $_FILES['class_image']['error'] == UPLOAD_ERR_OK) {
         $tmpName = $_FILES['class_image']['tmp_name'];
         $fileName = $_FILES['class_image']['name'];
         $destination = 'uploads/' . $fileName;
 
         if (move_uploaded_file($tmpName, $destination)) {
             $classImage = $destination;
         } else {
             echo 'Error moving the file.';
             exit;
         }
     }


    //  query to insert data into the classes table
    $insertQuery = "INSERT INTO classes (class_name, subject, school_year, class_code, class_image, teacher_idnum) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);
    mysqli_stmt_bind_param($stmt, "sssssi", $className, $subject, $schoolYear, $classCode, $classImage, $teacherID );

    if (mysqli_stmt_execute($stmt)) {
        // Class added successfully
    } else {
        // Error adding class
    }
}
?>
