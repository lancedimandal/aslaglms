<?php

include "stud-header-class.php";

?>

<style>
    /* DASHBOARD CONTENT */

.dash-content {

margin-top: 25px;
}

.dash-content h1 {

color: black;
background-color: #E2E2E2;
width: auto;
font-size: 25px;
}

.class-item {
  margin-top: 10px;
  display: block;
  align-items: center;
  margin-bottom: 20px;
  margin-left: 50px;
  width: auto;
  
}

.class-image {
  width: auto;
  height: auto;
  object-fit: cover;
  border-radius: 10px;
  margin-right: 20px;
  display: flex;

}

.class-details {
  font-size: 16px;
  font-weight: bold;
}



.class-name,
.subject,
.school-year,
.class-code {
  padding: 3px;
 
}

.class-item {
  display: flex;
  flex-direction: column;
  text-align: center;
  padding: 10px;
  background-color: #f5f5f5;
  border-radius: 20px;
  line-height: 0.5;
}

.class-image {
  width: 250px;
  height: 120px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 10px;
  transform: scale(1);
  transition: 0.3s ease-in-out;
}

.class-listed {

  width: 500px;
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  flex-grow: 1;
}

.class-title {

    font-size: 34px;
    margin-top: 20px;
    margin-left: 50px;
    font-weight: bold;
    border-bottom:  2px solid #ddd;
    width: 950px;
}



</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<?php
require_once 'config/connection.php';

if (!isset($_SESSION['student_idnum'])) {
    echo 'Student ID not found. Please log in.';
    exit; 
}

$studentID = $_SESSION['student_idnum'];

$selectQuery = "SELECT classes.class_id, classes.class_name, classes.subject, classes.class_image
                FROM classes
                INNER JOIN student_classes ON classes.class_id = student_classes.class_id
                WHERE student_classes.student_id = ?";
$stmt = mysqli_prepare($connection, $selectQuery);
mysqli_stmt_bind_param($stmt, "s", $studentID);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Display the enrolled classes in a three-column layout
    echo '<h1 class="class-title">Classes Enrolled</h1>';
    echo '<div class="class-listed">';
    while ($row = mysqli_fetch_assoc($result)) {
        $classID = $row['class_id'];
        $className = $row['class_name'];
        $subject = $row['subject'];
        $schoolYear = $row['school_year'];
        $classImage = $row['class_image'];

        echo '<div class="class-item">';
        echo '<div>';
        echo "<img src='" . $row['class_image'] . "' alt='Class Image' class='class-image'>";
        echo '<div>';
        echo '<h3>' . $className . '</h3>';
        echo '<p>Subject: ' . $subject . '</p>';
        echo '<p>School Year: ' . $schoolYear . '</p>';
        echo '<a class="btn btn-primary view-class-button" href="stud-dash.php?class_id=' . $classID . '">View Class</a>';
        echo '</div>'; // Close card-body
        echo '</div>'; // Close card
        echo '</div>'; // Close col-md-4
    }
    echo '</div>'; // Close the row
} else {
    // No enrolled classes found
    echo '<p id="no-class">You are not currently enrolled in any classes.</p>';
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>



<?php

include "stud-footer.php";
include "scripts.php";

?>