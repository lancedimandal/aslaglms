<?php
require_once 'config/connection.php';

// Check if the teacher ID is set in the session
if (!isset($_SESSION['teacher_idnum'])) {
    // Handle the case when the teacher ID is not set
    // For example, redirect to a login page or display an error message
    echo 'Teacher ID not found. Please log in.';
    exit; // Stop further execution
}

$teacherID = $_SESSION['teacher_idnum'];
// Define the number of quizzes to display per page
$quizzesPerPage = 4;

// Get the current page number for the quiz list from the query string
if (isset($_GET['quiz_page']) && is_numeric($_GET['quiz_page'])) {
    $currentQuizPage = (int)$_GET['quiz_page'];
} else {
    $currentQuizPage = 1; // Default to the first page
}

// Calculate the starting index of the quizzes to fetch from the database
$quizStartingIndex = ($currentQuizPage - 1) * $quizzesPerPage;

// Fetch quiz data from the database with LIMIT, OFFSET, and ORDER BY date_added
$quizSql = "SELECT quiz.*, classes.class_name AS class_name 
        FROM quiz 
        INNER JOIN classes ON quiz.class_id = classes.class_id 
        WHERE quiz.teacher_id = $teacherID
        ORDER BY quiz.date_added DESC
        LIMIT $quizStartingIndex, $quizzesPerPage";
$quizResult = mysqli_query($connection, $quizSql);

// Fetch total number of quizzes from the database
$totalQuizzesSql = "SELECT COUNT(*) AS total FROM quiz";
$totalQuizzesResult = mysqli_query($connection, $totalQuizzesSql);
$totalQuizzesRow = mysqli_fetch_assoc($totalQuizzesResult);
$totalQuizzes = $totalQuizzesRow['total'];
$totalQuizPages = ceil($totalQuizzes / $quizzesPerPage);

if ($quizResult && mysqli_num_rows($quizResult) > 0) {
    echo '<div class="container">';
    echo '<h1>Quiz List</h1>';
    echo '<table class="table table-bordered">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th scope="col">Class Name</th>'; // Added class name column
    echo '<th scope="col">Quiz Title</th>';
    echo '<th scope="col">Quiz Description</th>';
    echo '<th scope="col">Quiz Time Limit</th>';
    echo '<th scope="col">Question Time Limit</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($quizResult)) {
        $id = $row['quiz_id'];
        $className = $row['class_name']; // Get the class name
        $quizTitle  = $row['quiz_title'];
        $quizDesc = $row['quiz_description'];
        $quizTime = $row['quiz_time_limit'];
        $questionLimit = $row['question_time_display'];

        // Display each quiz row in the table
        echo '<tr>';
        echo '<td>' . $className . '</td>'; // Display the class name
        echo '<td>' . $quizTitle . '</td>';
        echo '<td>' . $quizDesc . '</td>';
        echo '<td>' . $quizTime . ' minutes</td>';
        echo '<td>' . $questionLimit . ' seconds</td>';
        echo '<td>';
        echo '<a href="question_quiz.php?id=' . $id . '" class="btn btn-success mr-2">Add Quiz</a>';
        echo '<a href="submission_quiz.php?id=' . $id . '" class="btn btn-secondary mr-2">Submission</a>';
        echo '<a href="update_quiz.php?id=' . $id . '" class="btn btn-primary mr-2">Update</a>';
        echo '<a href="delete_quiz.php?id=' . $id . '" class="btn btn-danger mr-2 delete-quiz-btn" data-toggle="modal" data-target="#deleteQuizConfirmationModal">Delete</a>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';

    // Pagination for quiz list
    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    if ($currentQuizPage > 1) {
        echo '<li class="page-item"><a class="page-link" href="?quiz_page=' . ($currentQuizPage - 1) . '">Previous</a></li>';
    }
    for ($i = 1; $i <= $totalQuizPages; $i++) {
        echo '<li class="page-item ' . ($currentQuizPage == $i ? 'active' : '') . '"><a class="page-link" href="?quiz_page=' . $i . '">' . $i . '</a></li>';
    }
    if ($currentQuizPage < $totalQuizPages) {
        echo '<li class="page-item"><a class="page-link" href="?quiz_page=' . ($currentQuizPage + 1) . '">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';

    echo '</div>';
} else {
    echo '<div class="container">';
    echo '<p style = "font-weight: bold; font-size: 24px">No Quiz found. Click Assessment to Add Quiz</p>';
    echo '</div>';
}
?>

<!-- Confirmation Modal -->
<div class="modal fade" id="deleteQuizConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteQuizConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteQuizConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this quiz?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteQuizButton">Delete</button>
      </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the "Delete" buttons
    const deleteQuizButtons = document.querySelectorAll(".delete-quiz-btn");
    const confirmDeleteQuizButton = document.getElementById("confirmDeleteQuizButton");

    deleteQuizButtons.forEach(button => {
      button.addEventListener("click", function() {
        // Get the quiz ID from the href attribute
        const quizId = this.getAttribute("href").split("=")[1];

        // Add a click event listener to the "Delete" button in the modal
        confirmDeleteQuizButton.addEventListener("click", function() {
          // Send AJAX request to delete_quiz.php to delete the quiz
          const xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                // Quiz deleted successfully, reload the page
                location.reload();
              } else {
                // Handle error if necessary
                alert("An error occurred while deleting the quiz.");
              }
            }
          };
          xhr.open("GET", "delete_quiz.php?id=" + quizId, true);
          xhr.send();
        });
      });
    });
  });
</script>
