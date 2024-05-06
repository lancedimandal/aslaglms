<?php
require_once 'config/connection.php';
session_start(); 

if (!isset($_SESSION['teacher_idnum'])) {
    echo 'Teacher ID not found. Please log in.';
    exit; 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacherID = $_SESSION['teacher_idnum'];
    $classID = $_SESSION['class_id'];

    $lesName = $_POST['lessonTitle'];
    $lesDesc = $_POST['lessonDescription'];

    $imageFolder = "lesson-image/";
    $imageFileName = $_FILES['lessonImage']['name'];
    $imageFilePath = $imageFolder . $imageFileName;
    $tempFilePath = $_FILES['lessonImage']['tmp_name'];
    move_uploaded_file($tempFilePath, $imageFilePath);

    $insertQuery = "INSERT INTO lessons (lesson_title, lesson_description, teacher_id, class_id, lesson_image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $insertQuery);

    mysqli_stmt_bind_param($stmt, "ssiis", $lesName, $lesDesc, $teacherID, $classID, $imageFilePath);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Lesson added successfully.';
    } else {
        echo 'Error adding lesson.';
    }
}
?>
