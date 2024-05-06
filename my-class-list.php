<?php
require_once 'config/connection.php';

// Check if the teacher ID is set in the session
if (!isset($_SESSION['teacher_idnum'])) {
    // Handle the case when the teacher ID is not set
    // For example, redirect to a login page or display an error message
    echo 'Teacher ID not found. Please log in.';
    exit; // Stop further execution
}

// Get the teacher ID from the session variable
$teacherID = $_SESSION['teacher_idnum'];

// Retrieve the classes for the logged-in teacher
$selectQuery = "SELECT * FROM classes WHERE teacher_idnum = ?";
$stmt = mysqli_prepare($connection, $selectQuery);
mysqli_stmt_bind_param($stmt, "i", $teacherID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Display the classes
    while ($row = mysqli_fetch_assoc($result)) {
        $subject = $row['subject'];
        $schoolYear = $row['academic_year'];
        $subject_id = $row['subject_id']; // Assuming the column name is 'subject_id'
        $section_id = $row['section_id']; // Assuming the column name is 'section_id'

        // Retrieve subject information based on subject_id
        $subject_query = mysqli_query($connection, "SELECT * FROM subject WHERE subject_id = $subject_id");
        $subject_data = mysqli_fetch_assoc($subject_query);
        $subject_name = $subject_data['subject_description']; // Assuming the column name is 'subject_name'

        // Retrieve section information based on section_id
        $section_query = mysqli_query($connection, "SELECT * FROM sections WHERE id = $section_id");
        $section_data = mysqli_fetch_assoc($section_query);
        $section_name = $section_data['section']; // Assuming the column name is 'section_name'

        // Display the class only if the image is a valid JPG or PNG
        $imagePath = "./admin/upload/";
        $imageFilename = $row['class_image'];

        $imageExtension = strtolower(pathinfo($imageFilename, PATHINFO_EXTENSION));
        if ($imageExtension === 'jpg' || $imageExtension === 'jpeg' || $imageExtension === 'png') {
            echo '<div class="class-item" data-class-id="' . $row['class_id'] . '">';
            echo "<img src='" . $imagePath . $imageFilename . "' alt='Class Image' class='class-image'>";
            echo '<p class="subject">Subject: ' . $subject_name . '</p>';
            echo '<p class="section">Section: ' . $section_name . '</p>';
            echo '<p class="school-year">Academic Year: ' . $schoolYear . '</p>';
            echo '<button class="btn btn-primary view-class-button">View Class</button>';
            echo "<button class='remove-button' data-class_id='" . $row['class_id'] . "'><i class='fas fa-trash-alt'></i> Remove</button>";
            echo '</div>';
        }
    }
} else {
    // No classes found
    echo '<p id="no-class">No classes found.</p>';
}
// JavaScript to handle the "View Class" button click event and set the cookie
?>
<script>
    // Get all the "View Class" buttons
    const viewClassButtons = document.querySelectorAll('.view-class-button');

    // Add event listener to each button
    viewClassButtons.forEach((button) => {
        button.addEventListener('click', () => {
            // Get the class ID from the button's parent element's data attribute
            const classId = button.parentElement.getAttribute('data-class-id');

            // Get the existing recent classes from the cookie or create an empty array
            let recentClasses = JSON.parse(getCookie('recent_classes') || '[]');

            // Add the current class ID to the recentClasses array
            recentClasses.push(classId);

            // Limit the array to the last 5 viewed classes (or any desired limit)
            recentClasses = recentClasses.slice(-6);

            // Convert the array back to a JSON string and set the cookie
            document.cookie = `recent_classes=${JSON.stringify(recentClasses)}; path=/;`;

            // Redirect to view-class.php with the class ID as a query parameter
            window.location.href = `view-class.php?class_id=${classId}`;
        });
    });

    // Function to get the value of a cookie by its name
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
</script>