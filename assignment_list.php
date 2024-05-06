
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

// Define the number of assignments to display per page
$assignmentsPerPage = 4;

// Get the current page number for the assignment list from the query string
if (isset($_GET['assignment_page']) && is_numeric($_GET['assignment_page'])) {
    $currentAssignmentPage = (int)$_GET['assignment_page'];
} else {
    $currentAssignmentPage = 1; // Default to the first page
}

// Calculate the starting index of the assignments to fetch from the database
$assignmentStartingIndex = ($currentAssignmentPage - 1) * $assignmentsPerPage;

// Fetch assignment data from the database with LIMIT, OFFSET, and ORDER BY date_added
$assignmentSql = "SELECT assignments.*, classes.class_name AS class_name 
        FROM assignments 
        INNER JOIN classes ON assignments.class_id = classes.class_id 
        WHERE assignments.teacher_id = $teacherID
        ORDER BY assignments.date_added DESC
        LIMIT $assignmentStartingIndex, $assignmentsPerPage"; // Use LIMIT and OFFSET in the query directly
$assignmentResult = mysqli_query($connection, $assignmentSql);

// Fetch total number of assignments from the database
$totalAssignmentsSql = "SELECT COUNT(*) AS total FROM assignments WHERE teacher_id = $teacherID";
$totalAssignmentsResult = mysqli_query($connection, $totalAssignmentsSql);
$totalAssignmentsRow = mysqli_fetch_assoc($totalAssignmentsResult);
$totalAssignments = $totalAssignmentsRow['total'];
$totalAssignmentPages = ceil($totalAssignments / $assignmentsPerPage);

if ($assignmentResult && mysqli_num_rows($assignmentResult) > 0) {
    echo '<div class="container">';
    echo '<h1>Assignment List</h1>';
    echo '<table class="table table-bordered">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th scope="col">Class Name</th>'; // Added class name column
    echo '<th scope="col">Title</th>';
    echo '<th scope="col">Date Added</th>';
    echo '<th scope="col">Deadline</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($assignmentResult)) {
        $id = $row['assignment_id'];
        $className = $row['class_name']; // Get the class name
        $assignmentTitle  = $row['assignment_title'];
        $assignmentDesc = $row['assignment_description'];
        $dateAdded = date('F j, Y g:i a', strtotime($row['date_added'])); // Format the date added
        $deadline = date('F j, Y g:i a', strtotime($row['deadline'])); // Format the deadline

        // Display each assignment row in the table
        echo '<tr>';
        echo '<td>' . $className . '</td>'; // Display the class name
        echo '<td>' . $assignmentTitle . '</td>';
    
        echo '<td>' . $dateAdded . '</td>';
        echo '<td>' . $deadline . '</td>';
        echo '<td>';
        echo '<a href="question_assignment.php?id=' . $id . '" class="btn btn-success mr-2">Assignment</a>';
        // Update button with link to the update_assignment.php page and passing the assignment ID as a parameter
        echo '<a href="submission_assign.php?id=' . $id . '" class="btn btn-secondary mr-2">Submission</a>';
        echo '<a href="update_assignment.php?id=' . $id . '" class="btn btn-primary mr-2">Update</a>';
        // Delete button with link to the delete_assignment.php page and passing the assignment ID as a parameter
        echo '<button type="button" class="btn btn-danger mr-2 delete-assignment-btn" data-assignment-id="' . $id . '" data-toggle="modal" data-target="#modalassigndelete">Delete</button>';
        echo '</td>';
        echo '</tr>';
        
    }

    echo '</tbody>';
    echo '</table>';

    // Pagination for assignment list
    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';
    if ($currentAssignmentPage > 1) {
        echo '<li class="page-item"><a class="page-link" href="?assignment_page=' . ($currentAssignmentPage - 1) . '">Previous</a></li>';
    }
    for ($i = 1; $i <= $totalAssignmentPages; $i++) {
        echo '<li class="page-item ' . ($currentAssignmentPage == $i ? 'active' : '') . '"><a class="page-link" href="?assignment_page=' . $i . '">' . $i . '</a></li>';
    }
    if ($currentAssignmentPage < $totalAssignmentPages) {
        echo '<li class="page-item"><a class="page-link" href="?assignment_page=' . ($currentAssignmentPage + 1) . '">Next</a></li>';
    }
    echo '</ul>';
    echo '</nav>';

    echo '</div>';
} else {
    echo '<div class="container">';
    echo '<p style="font-weight: bold; font-size: 24px">No assignments found.</p>';
    echo '</div>';
}

?>

<!-- Confirmation Modal -->
<div class="modal fade" id="modalassigndelete" tabindex="-1" role="dialog" aria-labelledby="modalassigndeleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalassigndeleteLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this assignment?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="assignDeleteButton">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
  // Add event listener to the "Delete" buttons
  const deleteAssignmentButtons = document.querySelectorAll(".delete-assignment-btn");
  const confirmDeleteButton = document.getElementById("assignDeleteButton");

  deleteAssignmentButtons.forEach(button => {
    button.addEventListener("click", function() {
      // Get the assignment ID from the data attribute
      const assignmentId = this.getAttribute("data-assignment-id");

      // Add a click event listener to the "Delete" button in the modal
      confirmDeleteButton.addEventListener("click", function() {
        // Send AJAX request to delete_assignment.php to delete the assignment
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
          if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
              // Parse the JSON response
              const response = JSON.parse(xhr.responseText);
              if (response.status === 'success') {
                // Assignment deleted successfully, reload the page
                location.reload();
              } else {
                // Display error message if deletion fails
                alert("An error occurred while deleting the assignment.");
              }
            } else {
              // Handle error if necessary
              alert("An error occurred while deleting the assignment.");
            }
          }
        };
        xhr.open("GET", "delete_assign.php?id=" + assignmentId, true);
        xhr.send();
      });
    });
  });
});

</script>


