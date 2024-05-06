<?php
require 'config/connection.php';


if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];
}
$studentsPerPage = 10; 

$query = "SELECT COUNT(*) AS total FROM students";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
$totalStudents = $row['total'];
$totalPages = ceil($totalStudents / $studentsPerPage);

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $studentsPerPage;

$searchKeyword = isset($_GET['search_query']) ? $_GET['search_query'] : '';
$searchYearLevel = isset($_GET['year_level']) ? $_GET['year_level'] : '';
$searchCourse = isset($_GET['course_search']) ? $_GET['course_search'] : '';
$searchSection = isset($_GET['section_search']) ? $_GET['section_search'] : '';


$searchConditions = [];

if (!empty($searchKeyword)) {
    $searchConditions[] = "(student_idnum LIKE '%$searchKeyword%' OR full_name LIKE '%$searchKeyword%')";
}

if (!empty($searchYearLevel)) {
    $searchConditions[] = "year_level = " . intval($searchYearLevel);
}

if (!empty($searchCourse)) {
    $searchConditions[] = "course LIKE '%$searchCourse%'";
}

if (!empty($searchSection)) {
    $searchSection = mysqli_real_escape_string($connection, $searchSection);
    $searchConditions[] = "UPPER(section) = '" . strtoupper($searchSection) . "'";
}

$searchCondition = '';

if (!empty($searchConditions)) {
    $searchCondition = "WHERE " . implode(" AND ", $searchConditions);
}

$query = "SELECT * FROM students $searchCondition LIMIT $start, $studentsPerPage";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="student-container">';
    echo '<table class="table table-striped">';
    echo '<tr>
            <th>Student ID</th>
            <th>Full Name</th>
            <th>Course</th>
            <th>Year Level</th>
            <th>Email</th>
            <th></th>
        </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['student_idnum'] . '</td>';
            echo '<td>' . $row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name'] . '</td>';
            echo '<td>' . $row['course'] . '</td>';
            echo '<td>' . $row['year_level'] . '</td>';
            echo '<td>' . $row['email'] . '</td>';
            echo '<td>';
            echo '<form action="class-enrolled.php" method="post">';
            echo '<input type="hidden" name="student_id" value="' . $row['student_idnum'] . '">';
            echo '<button type="button" class="btn btn-primary btn-enroll-student" onclick="enrollStudent(' . $row['student_idnum'] . ')">Add</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        
    echo '</table>';
    echo '</div>';

    // Display Bootstrap pagination links
    echo '<div class="pagination">';
    echo '<ul class="pagination">';
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
    } else {
        echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
    }
    echo '</ul>';
    echo '</div>';
} else {
    echo '<p id="no-stud">No students found.</p>';
}
?>
<script>
function enrollStudent(studentID) {
    $.ajax({
        type: "POST",
        url: "enrolled_students.php", // URL for enrolling the student
        data: { student_id: studentID },
        success: function(response) {
            if (response === "success") {
                // Remove the enrolled student's row from the table
                $("#row-" + studentID).remove();
            }
        }
    });
}
</script>