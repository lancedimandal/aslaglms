

<?php
require_once 'config/connection.php';
session_start();

// Check if the student ID is set in the session
if (!isset($_SESSION['student_idnum'])) {
    // Handle the case when the student ID is not set
    // For example, redirect to a login page or display an error message
    echo 'Student ID not found. Please log in.';
    exit; // Stop further execution
}
?>
<?php include "student-module-header.php";
//// Retrieve class details from the database
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
    }}?>
<!DOCTYPE html>
<html>
<head>
    <title>Lesson List</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .lesson-container {
            padding: 20px;
        }
        .lesson-container h4 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .table-responsive {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="lesson-container">

<div class="lesson-container">
    <?php
    require_once "config/connection.php";

    if (!isset($_GET['lesson_id'])) {
        die("Lesson ID parameter is missing.");
    }

    $lesson_id = $_GET['lesson_id'];

    $lesson_title = "";
    $result = null;

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
        $query = "SELECT lesson_title FROM lessons WHERE lesson_id='$lesson_id'";
        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $lesson_title = $row['lesson_title'];
        } else {
            echo "Lesson not found.";
        }
    }
    ?>
    
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h4><?php echo $lesson_title; ?></h4>
    <a class="btn btn-primary mt-3" href="stud-dash.php?class_id=<?php echo $classID; ?>">Back to Dashboard</a>
    
</div>


<div class="container mt-4">
        <?php
        require_once 'config/connection.php';
        date_default_timezone_set('Asia/Manila');

        $apiKey = 'AIzaSyDZ9kUim65kpTJZ9dFVB-eNYZVYLeD4YHY';

        if (isset($_GET['class_id']) && isset($_GET['lesson_id'])) {
            $classId = $_GET['class_id'];
            $lessonId = $_GET['lesson_id'];

            $currentDateTime = date('Y-m-d H:i:s'); // Get the current date and time

            $query = "SELECT lesson_files.*, lessons.lesson_title, lesson_files.`title_lesson`
            FROM lesson_files
            INNER JOIN lessons ON lesson_files.lesson_id = lessons.lesson_id
            WHERE lessons.class_id = $classId 
            AND lesson_files.lesson_id = $lessonId
            AND lesson_files.scheduled_time <= '$currentDateTime'"; 


            $result = mysqli_query($connection, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<h3 class="mb-4">Lesson Materials</h3>';
                echo '<div class="table-responsive">';
                echo '<table class="table table-bordered table-striped">';
                echo '<thead class="thead-dark">';
                echo '<tr>';
                echo '<th scope="col">Lesson Title</th>';
                echo '<th scope="col">Resource</th>';
                echo '<th scope="col">Date Added</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $fileType = $row['file_type'];
                    $fileUrl = $row['file_url'];
                    $fileName = basename($fileUrl);
                    $youtubeLink = $row['youtube_link'];
                    $dateAdded = date('F j, Y h:i A', strtotime($row['date_added']));
                    $lessonTitle = $row['title_lesson'];

                    echo '<tr>';
                    echo '<td>' . $lessonTitle . '</td>';
                    echo '<td>';

                    if (!empty($fileUrl)) {
                        echo '<a href="' . $fileUrl . '" target="_blank">' . $fileName . '</a>';
                    }

                    if (!empty($youtubeLink)) {
                        $videoId = getYouTubeVideoId($youtubeLink);
                        if (!empty($videoId)) {
                            $videoInfoUrl = "https://www.googleapis.com/youtube/v3/videos?id=$videoId&key=$apiKey&part=snippet";
                            $response = file_get_contents($videoInfoUrl);

                            if ($response !== false) {
                                $videoInfo = json_decode($response, true);
                                if (isset($videoInfo['items'][0]['snippet']['title'])) {
                                    $videoTitle = $videoInfo['items'][0]['snippet']['title'];
                                    echo ' | <a href="' . $youtubeLink . '" target="_blank">' . $videoTitle . '</a>';
                                }
                            }
                        } else {
                            echo ' | <a href="' . $youtubeLink . '" target="_blank">YouTube Link</a>';
                        }
                    }

                    echo '</td>';
                    echo '<td>' . $dateAdded . '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
                echo '</div>';
            } else {
                echo '<p class="mt-4">No uploaded resources found.</p>';
            }
        } else {
            echo '<p class="mt-4">Class ID and Lesson ID not provided in the URL.</p>';
        }

        function getYouTubeVideoId($url) {
            $queryString = parse_url($url, PHP_URL_QUERY);
            parse_str($queryString, $params);
            return isset($params['v']) ? $params['v'] : '';
        }
        ?>
    </div>

<?php
include "stud-footer.php";
?>