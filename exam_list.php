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

// Define the number of exams to display per page
$examsPerPage = 4;

// Get the current page number from the query string
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1; // Default to the first page
}

// Calculate the starting index of the exams to fetch from the database
$startingIndex = ($currentPage - 1) * $examsPerPage;

// Fetch exam data from the database with LIMIT and OFFSET, including exam_id and class_name
$sql = "SELECT exams.*, classes.class_name AS class_name, classes.subject AS subject
        FROM exams 
        INNER JOIN classes ON exams.class_id = classes.class_id 
        WHERE exams.teacher_id = $teacherID
        LIMIT $examsPerPage OFFSET $startingIndex";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<h1>Exam List</h1>';
    echo '<table class="table table-bordered">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th scope="col">Class Name</th>'; // Added class name column
    echo '<th scope="col">Subject</th>';
    echo '<th scope="col">Exam Title</th>';
    echo '<th scope="col">Exam Time Limit</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['exam_id'];
        $classId = $row['class_id']; // Get the class ID
        $className = $row['class_name'];
        $examTitle  = $row['exam_title'];
        $examDesc = $row['exam_description'];
        $examTime = $row['exam_time_limit'];
        $subject = $row ['subject'];
    
        // Display each exam row in the table
        echo '<tr class = "">';
        echo '<td>' . $className . '</td>'; // Display the class name
        echo '<td>' . $subject . '</td>';
        echo '<td>' . $examTitle . '</td>';
        echo '<td>' . $examTime . ' minutes</td>';
        echo '<td>';
        // Modify the link for the "Question" button to include the exam ID and class ID as parameters
        echo '<a href="question_exam.php?exam_id=' . $id . '&class_id=' . $classId . '" class="btn btn-success mr-2">Question</a>';
        echo '<a href="submission_exam.php?id=' . $id . '" class="btn btn-secondary mr-2">Submission</a>';
        echo '<a href="update_exam.php?id=' . $id . '" class="btn btn-primary mr-2">Update</a>';
        echo '<button type="button" class="btn btn-danger mr-2 delete-exam-btn" data-exam-id="' . $id . '" data-toggle="modal" data-target="#deleteConfirmationModal">Delete</button>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // Pagination
    $totalExamsSql = "SELECT COUNT(*) AS total FROM exams";
    $totalExamsResult = mysqli_query($connection, $totalExamsSql);
    $totalExamsRow = mysqli_fetch_assoc($totalExamsResult);
    $totalExams = $totalExamsRow['total'];
    $totalPages = ceil($totalExams / $examsPerPage);

    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    if ($currentPage > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item ' . ($currentPage == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }
    if ($currentPage < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';

    echo '</div>';
} else {
    echo '<div class="container">';
    echo '<p style = "font-weight: bold; font-size: 24px">No exams found. Click Assessment to Add Exam</p>';
    echo '</div>';
}
?>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this exam?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the "Delete" buttons
    const deleteExamButtons = document.querySelectorAll(".delete-exam-btn");
    const confirmDeleteButton = document.getElementById("confirmDeleteButton");

    deleteExamButtons.forEach(button => {
      button.addEventListener("click", function() {
        // Get the exam ID from the data attribute
        const examId = this.getAttribute("data-exam-id");

        // Add a click event listener to the "Delete" button in the modal
        confirmDeleteButton.addEventListener("click", function() {
          // Send AJAX request to delete_exam.php to delete the exam
          const xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                // Exam deleted successfully, reload the page
                location.reload();
              } else {
                // Handle error if necessary
                alert("An error occurred while deleting the exam.");
              }
            }
          };
          xhr.open("GET", "delete_exam.php?id=" + examId, true);
          xhr.send();
        });
      });
    });
  });
</script>

