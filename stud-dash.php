
<?php
session_start(); 
require 'config/connection.php';

// Function to handle student enrollment
function enrollStudent($class_code, $student_id, $connection) {
    // Check if the class code exists in the database
    $stmt_check_class = $connection->prepare("SELECT class_id FROM classes WHERE class_code = ?");
    $stmt_check_class->bind_param("s", $class_code);
    $stmt_check_class->execute();
    $result = $stmt_check_class->get_result();

    if ($result->num_rows === 1) {
        // Class code is valid, enroll the student
        $row = $result->fetch_assoc();
        $class_id = $row['class_id'];

        // Check if the student is not already enrolled in the class
        $stmt_check_enrollment = $connection->prepare("SELECT * FROM student_classes WHERE student_id = ? AND class_id = ?");
        $stmt_check_enrollment->bind_param("ii", $student_id, $class_id);
        $stmt_check_enrollment->execute();
        $result_enrollment = $stmt_check_enrollment->get_result();

        if ($result_enrollment->num_rows === 0) {
            // Student is not enrolled, insert the enrollment record
            $stmt_enroll_student = $connection->prepare("INSERT INTO student_classes (student_id, class_id) VALUES (?, ?)");
            $stmt_enroll_student->bind_param("ii", $student_id, $class_id);
            $stmt_enroll_student->execute();

            // Enrollment successful, return true
            return true;
        } else {
            // Student is already enrolled in the class, return false
            return false;
        }
    } else {
        // Class code is invalid, return false
        return false;
    }
}

// Check if the student is logged in and get the student ID
if (isset($_SESSION['student_idnum'])) {
    $student_id = $_SESSION['student_idnum'];

    // Check if the enrollment form is submitted
    if (isset($_POST["enroll"])) {
        $class_code = $_POST["class_code"]; // Get the entered class code (assuming it's submitted via a form)

        // Call the enrollStudent function to handle the enrollment process
        $enrollment_result = enrollStudent($class_code, $student_id, $connection);
        
        if ($enrollment_result) {
            // Enrollment successful
            echo '<script>alert("Enrollment successful."); window.location.href = "stud-dash.php";</script>';
            exit();
        } else {
            // Enrollment failed
            echo '<script>alert("Enrollment failed. Class code is invalid or you are already enrolled in the class."); window.history.back();</script>';
            exit();
        }
    }
} else {
    // Student is not logged in, redirect to the login page
    header("Location: student-login.php");
    exit();
}


?>

<?php include 'class-stud-header.php';?>

<?php

require_once 'config/connection.php';

// Check if the class ID is provided in the URL parameter
if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Fetch the class details from the database
    $selectQuery = "SELECT class_name, subject FROM classes WHERE class_id = ?";
    $stmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $classID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $classData = mysqli_fetch_assoc($result);
        $className = $classData['class_name'];
        $subject = $classData['subject'];
    } else {
        // No class found with the given class_id
        echo '<p>Class not found.</p>';
        exit;
    }

    // Retrieve the lessons uploaded by the teacher for this class
    $selectLessonsQuery = "SELECT * FROM lessons WHERE class_id = ?";
    $stmtLessons = mysqli_prepare($connection, $selectLessonsQuery);
    mysqli_stmt_bind_param($stmtLessons, "i", $classID);
    mysqli_stmt_execute($stmtLessons);
    $lessonsResult = mysqli_stmt_get_result($stmtLessons);
} else {
    // If class_id is not provided in the URL parameter, redirect back to the student's class list page.
    header("Location: stud-class-main.php");
    exit;
}
?>



<style>
    .lesson-image {

  width: 250px;
  height: 120px;
  object-fit: cover;
  border-radius: 5px;
  margin-bottom: 10px;
  transform: scale(1);
  transition: 0.3s ease-in-out;
    }
</style>

<style>

    #lesson-details {
        margin-top: 15px;
        margin-bottom: 20px;
    }
   
    
    .announcement {
        box-sizing: border-box;
        border: 1px solid darkgrey;
        display: flex;
        border-radius: 10px;
        padding: 15px;
        width: 260px;
        margin-bottom: 20px;
        margin-top: 10px;
        background-color: #f8f8f8; /* Adding background color */
    }
    .assessment-list-stud{

        box-sizing: border-box;
        border: 1px solid darkgrey;
        border-radius: 10px;
        padding: 15px;
        width: 260px;
        margin-bottom: 20px;
        margin-top: 10px;
        background-color: #f8f8f8; /* Adding background color */
    }

    .Meeting-Room {

        box-sizing: border-box;
        border: 1px solid darkgrey;
        border-radius: 10px;
        padding: 15px;
        width: 260px;
        margin-bottom: 20px;
        margin-top: 10px;
        background-color: #f8f8f8; /* Adding background color */
        
    }

    .announcements h3 {
        font-weight: bold;
         margin-bottom: 15px; /* Add some space below the heading */
    }

    .announcement .announcement-info {
        margin-bottom: 20px; /* Add space between each exam information */
     
    }
  
    .side-context {
        margin-bottom: 10px;
        
    }

 

</style>
<div class="container-fluid px-4"> 
        <div class="container">
            <div class="row">
                <div class="col-md-9" id="lesson" style="display: none;">
                    <div class="row" id="lesson-details">
                        <h1>Modules</h1>
                        <?php if (mysqli_num_rows($lessonsResult) > 0) {
                        $lessonsCount = 0;
                        while ($lessonData = mysqli_fetch_assoc($lessonsResult)) {
                            $lessonTitle = $lessonData['lesson_title'];
                            $lessonDescription = $lessonData['lesson_description'];
                            $lessonImage = $lessonData['lesson_image'];
                            $lessonFileURL = $lessonData['file_url'];

                            // Start a new row every 3 lessons
                            if ($lessonsCount % 3 === 0) {
                                echo '</div><div class="row">';
                            }
                            $lessonsCount++;
                    ?>
                            <div class="col-md-4 lesson" style="margin-bottom: 20px;">
                                <img class="lesson-image" src="<?php echo $lessonImage; ?>" alt="">
                                <h3><?php echo $lessonTitle; ?></h3>
                                <p><?php echo $lessonDescription; ?></p>
                                <a href="student-module.php?lesson_id=<?php echo $lessonData['lesson_id']; ?>&class_id=<?php echo $classID; ?>" class="btn btn-primary">View Module</a>
                            </div>
                    <?php
                        }
                    } else {
                        echo '<div class="col"><p>No lessons uploaded for this class.</p></div>';
                    }
                    ?>
                    </div>
                </div> 
                <div class="col-md-3" id="side-content" style="display: none;">
                    
                    <div class="side-context">
                        <div class="announcement">
                        <?php
                            // Assuming you have already connected to your database here.
                            require_once 'config/connection.php';
                            date_default_timezone_set('Asia/Manila');

                            // Check if the student ID is set in the session
                            if (!isset($_SESSION['student_idnum'])) {
                                // Handle the case when the student ID is not set
                                // For example, redirect to a login page or display an error message
                                echo 'Student ID not found. Please log in.';
                                exit; // Stop further execution
                            }

                            // Get the student ID from the session
                            $studentID = $_SESSION['student_idnum'];

                            // Check if the class ID is set in the URL parameter
                            if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
                                // Handle the case when the class ID is not provided or not numeric
                                echo 'Invalid class ID.';
                                exit; // Stop further execution
                            }

                            // Get the class ID from the URL parameter
                            $classID = $_GET['class_id'];

                            $sql_teacher_id = "SELECT teacher_id FROM announcements WHERE class_id = ?";
                            $stmt_teacher_id = mysqli_prepare($connection, $sql_teacher_id);
                            mysqli_stmt_bind_param($stmt_teacher_id, "i", $classID);
                            mysqli_stmt_execute($stmt_teacher_id);
                            mysqli_stmt_bind_result($stmt_teacher_id, $teacherID);

                            if (mysqli_stmt_fetch($stmt_teacher_id) === false) {
                                // Handle the case when the class ID is not found for the student
                                echo 'Invalid class ID or you are not enrolled in this class.';
                                exit;
                            }

                            // Close the statement
                            mysqli_stmt_close($stmt_teacher_id);

                            $currentDateTime = date('Y-m-d H:i:s'); // Get the current date and time

                            // Query to get the announcements for the student's class
                            $sql_announcements = "SELECT announcement_id, title, date_created, content, start, expiry_date
                                                FROM announcements
                                                WHERE class_id = ? AND teacher_id = ?
                                                AND start <= ? AND expiry_date >= ?
                                                ORDER BY date_created DESC";

                            // Prepare the statement
                            $stmt_announcements = mysqli_prepare($connection, $sql_announcements);

                            // Bind the class ID, teacher ID, current date and time to the prepared statement
                            mysqli_stmt_bind_param($stmt_announcements, "iiss", $classID, $teacherID, $currentDateTime, $currentDateTime);

                            // Execute the query
                            mysqli_stmt_execute($stmt_announcements);

                            // Get the result
                            $result_announcements = mysqli_stmt_get_result($stmt_announcements);
                            ?>

                                    <div class="announcements">
                                            <h3>Announcement</h3>
                                            <?php
                                    if (mysqli_num_rows($result_announcements) > 0) {
                                        // Display the list of announcements
                                        while ($row_announcement = mysqli_fetch_assoc($result_announcements)) {
                                            $announcementTitle = $row_announcement['title'];
                                            $announcementDesc = $row_announcement['content'];
                                            $announcementDate = $row_announcement['date_created'];

                                            // Display the announcement text and date
                                            echo '<div class="announcement-info">';
                                            echo '<h3>' . $announcementTitle . '</h3>';
                                            echo '<p>' . $announcementDesc . '</p>';
                                            echo '<p class="announcement-date">Posted on ' . date("F j, Y h:i A", strtotime($announcementDate)) . '</p>';
                                            echo '</div>';
                                        }
                                    } else {
                                        echo '<p>No announcements.</p>';
                                    }
                                    ?>
                        </div>
                    </div>     
                    <div class="assessment-list-stud">
                        <h2>Assessment List</h2>
                        <?php
                      
                            require_once 'config/connection.php';
                            if (!isset($_SESSION['student_idnum'])) {
                                echo 'Student ID not found. Please log in.';
                                exit; 
                            }
                            $studentID = $_SESSION['student_idnum'];

                            if (!isset($_GET['class_id']) || !is_numeric($_GET['class_id'])) {
                                echo 'Invalid class ID.';
                                exit; 
                            }
                            $classID = $_GET['class_id'];

                            // Query to get the counts of available exams, quizzes, activities, and assignments
                            $sql_counts = "SELECT 
                                (SELECT COUNT(*) FROM exams e WHERE e.class_id = ? AND NOT EXISTS (SELECT 1 FROM student_taken_exams ste WHERE ste.exam_id = e.exam_id AND ste.student_id = ?)) AS exam_count,
                                (SELECT COUNT(*) FROM quiz q WHERE q.class_id = ? AND NOT EXISTS (SELECT 1 FROM student_taken_quiz stq WHERE stq.quiz_id = q.quiz_id AND stq.student_id = ?)) AS quiz_count,
                                (SELECT COUNT(*) FROM activities act WHERE act.class_id = ? AND NOT EXISTS (SELECT 1 FROM student_taken_acts sta WHERE sta.activity_id = act.activity_id AND sta.student_id = ?)) AS activity_count,
                                (SELECT COUNT(*) FROM assignments a WHERE a.class_id = ? AND NOT EXISTS (SELECT 1 FROM student_taken_assign sta WHERE sta.assignment_id = a.assignment_id AND sta.student_id = ?)) AS assignment_count";

                            // Prepare the statement
                            $stmt_counts = mysqli_prepare($connection, $sql_counts);

                            // Bind the class ID and student ID parameters to the prepared statement
                            mysqli_stmt_bind_param($stmt_counts, "iiiiiiii", $classID, $studentID, $classID, $studentID, $classID, $studentID, $classID, $studentID);

                            // Execute the query
                            mysqli_stmt_execute($stmt_counts);

                            // Get the result
                            $result_counts = mysqli_stmt_get_result($stmt_counts);
                            $row_counts = mysqli_fetch_assoc($result_counts);
                            ?>

                            <a style = "text-decoration: none; color: black;"href="#"><p><?php echo $row_counts['exam_count']; ?> Exams Available</p></a>
                            <a style = "text-decoration: none; color: black;"href="#"><p><?php echo $row_counts['quiz_count']; ?> Quizzes Available</p></a>
                            <a style = "text-decoration: none; color: black;"href="#>"><p><?php echo $row_counts['activity_count']; ?> Activities Available</p></a>
                            <a style = "text-decoration: none; color: black;"href="#"><p><?php echo $row_counts['assignment_count']; ?> Assignments Available</p></a>
                                                
                    </div>
                    <div class="Meeting-Room">
    <h2>Meeting Room</h2>
    <?php
    date_default_timezone_set('Asia/Manila'); // Set the timezone to Manila

    if (isset($_GET['class_id'])) {
        $roomId = $_GET['class_id'];
        $roomDetails = getRoomDetailsFromDatabase($roomId);

        if ($roomDetails) {
            $roomLink = $roomDetails['room_name'];
            $scheduledTime = strtotime($roomDetails['scheduled_time']);
            $currentServerTime = time(); // Get the current server time
            /*
            echo "Scheduled Time: " . date("Y-m-d H:i:s", $scheduledTime) . "<br>";
            echo "Current Server Time: " . date("Y-m-d H:i:s", $currentServerTime) . "<br>";
            */
            if ($currentServerTime >= $scheduledTime) {
                $completeRoomLink = "https://meet.jit.si/" . $roomLink;
                echo "Room Link: <a href='$completeRoomLink' target='_blank'>$completeRoomLink</a>";
            } else {
                echo "Room Link: N/A";
            }
        } else {
            echo "Room Link: N/A";
        }
    } else {
        echo "Class ID not available in session.";
    }

    function getRoomDetailsFromDatabase($classId) {
        require('config/connection.php');

        $query = "SELECT room_name, scheduled_time FROM room_links WHERE class_id = ?";

        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $classId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row;
        } else {
            $stmt->close();
            return null;
        }
    }
    ?>
</div>


                </div>
            </div>
        
            <div class="container" id="assess-content"  style="display: none; margin-left:-10px;margin-top:10px;">
                <?php include 'assess.php';?>
            </div>
        </div>
    </div>

    

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Cache the references to the relevant elements
    var examLink = $('#exam-link'); // Replace with the actual ID of the "Exam" link
    var dashboardLink = $('#dashboard-link'); // Replace with the actual ID of the "Dashboard" link
    var lessonList = $('#lesson');
    var sideContent = $('#side-content');
    var assessContent = $('#assess-content');

    // Check if the stored state is "assess" or "dashboard"
    var storedState = localStorage.getItem('pageState');
    if (storedState === 'assess') {
        // Hide other elements and show the assess content
        lessonList.hide();
        sideContent.hide();
        assessContent.show();
    } else if (storedState === 'dashboard') {
        // Show the lesson list and side content
        lessonList.show();
        sideContent.show();
        assessContent.hide();
    }

    // Add a click event listener to the "Exam" link
    examLink.on('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        // Store the state as "assess"
        localStorage.setItem('pageState', 'assess');

        // Hide other elements and show the assess content
        lessonList.hide();
        sideContent.hide();
        assessContent.show();
    });

    // Add a click event listener to the "Dashboard" link
    dashboardLink.on('click', function(event) {
        event.preventDefault(); // Prevent the default link behavior

        // Store the state as "dashboard"
        localStorage.setItem('pageState', 'dashboard');

        // Show the lesson list and side content
        lessonList.show();
        sideContent.show();
        assessContent.hide();
    });

    // Add a 2-second delay when reloading the page
    setTimeout(function() {
        // Your code to show/hide elements here
    }, 2000);
});
</script>



<?php
include "stud-footer.php";
include "scripts.php";
?>
