<?php 
require 'config/connection.php';

// Assuming you have the teacher's ID stored in a session variable called 'teacher_id'
session_start(); // Start the session (if not already started)

if (isset($_SESSION['teacher_idnum'])) {
    $teacherId = $_SESSION['teacher_idnum'];
    
    // Fetch classes with subject and section information from your database using prepared statement
    $sql = "SELECT c.class_id, s.subject_description, sec.section
            FROM classes c
            JOIN subject s ON c.subject_id = s.subject_id
            JOIN sections sec ON c.section_id = sec.id
            WHERE c.teacher_idnum = ?";
            
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $teacherId);
    $stmt->execute();
    $result = $stmt->get_result();

    $classes = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $classes[] = $row;
        }
    }

    $stmt->close();
    $connection->close();

    // Return JSON response
    header("Content-Type: application/json");
    echo json_encode($classes);
} else {
    echo "Teacher ID not found in session.";
}
?>
