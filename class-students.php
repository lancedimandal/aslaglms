<?php
require 'config/connection.php';

if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Fetch the class details
    $classQuery = "SELECT * FROM classes WHERE class_id = $classID";
    $classResult = mysqli_query($connection, $classQuery);
    $classRow = mysqli_fetch_assoc($classResult);

    if ($classRow) {
        // Display class details
        /*
        echo '<h2>Class Details</h2>';
        echo '<p>Class Name: ' . $classRow['class_name'] . '</p>';
        echo '<p>Class Code: ' . $classRow['class_code'] . '</p>';
        // Add other class details as needed
        */

        // Fetch enrolled students for the class
        $enrolledQuery = "SELECT students.*, student_classes.class_id FROM students 
                          INNER JOIN student_classes ON students.student_idnum = student_classes.student_id
                          WHERE student_classes.class_id = $classID";
        $enrolledResult = mysqli_query($connection, $enrolledQuery);

        if (mysqli_num_rows($enrolledResult) > 0) {
            // Display the list of enrolled students
            echo '<h2>Enrolled Students</h2>';
            echo '<table class="table table-striped">';
            echo '<tr>
                <th>Student ID</th>
                <th>Full Name</th>
                <th>Course</th>
                <th>Section</th>
                <th>Year Level</th>
                <th>Email</th>
            </tr>';

            while ($row = mysqli_fetch_assoc($enrolledResult)) {
                echo '<tr>';
                echo '<td>' . $row['student_idnum'] . '</td>';
                echo '<td>' . $row['full_name'] . '</td>';
                echo '<td>' . $row['course'] . '</td>';
                echo '<td>' . $row['section'] . '</td>';
                echo '<td>' . $row['year_level'] . '</td>'; 
                echo '<td>' . $row['email'] . '</td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo '<p>No students enrolled in this class.</p>';
        }
    } else {
        echo '<p>Class not found.</p>';
    }
} else {
    echo '<p>Class ID not specified.</p>';
}
?>
