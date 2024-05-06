<?php
require_once 'config/connection.php';

// Check if the class ID is provided
if (!isset($_GET['class_id'])) {
    echo 'Class ID not provided.';
    exit;
}

$classId = $_GET['class_id'];

// Retrieve the class details from the database
$selectQuery = "SELECT * FROM classes WHERE class_id = ?";
$stmt = mysqli_prepare($connection, $selectQuery);
mysqli_stmt_bind_param($stmt, "i", $classId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Class found, display the class overview
    $class = mysqli_fetch_assoc($result);
    $className = $class['class_name'];
    $subject = $class['subject'];
    $schoolYear = $class['school_year'];
    $classCode = $class['class_code'];
    $classImage = $class['class_image'];

    // Display the class overview content
    echo '<h2>Class Overview</h2>';
    echo '<div>';
    echo "<img src='" . $classImage . "' alt='Class Image' class='class-image'>";
    echo '<h3>' . $className . '</h3>';
    echo '<p>Subject: ' . $subject . '</p>';
    echo '<p>School Year: ' . $schoolYear . '</p>';
    echo '<p>Class Code: ' . $classCode . '</p>';
    echo '</div>';

    // Additional class overview content goes here
} else {
    // Class not found
    echo 'Class not found.';
}
?>