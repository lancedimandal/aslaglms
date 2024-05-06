<?php
require_once 'config/connection.php';


if (!isset($_SESSION['teacher_idnum'])) {

  echo 'Teacher ID not found. Please log in.';
  exit;
}

// Get the teacher ID from the session variable
$teacherID = $_SESSION['teacher_idnum'];

// Define the number of activities to display per page
$activitiesPerPage = 4;

// Get the current page number for the activity list from the query string
if (isset($_GET['activity_page']) && is_numeric($_GET['activity_page'])) {
  $currentActivityPage = (int) $_GET['activity_page'];
} else {
  $currentActivityPage = 1; // Default to the first page
}

// Calculate the starting index of the activities to fetch from the database
$activityStartingIndex = ($currentActivityPage - 1) * $activitiesPerPage;

// Fetch activity data from the database with LIMIT, OFFSET, and ORDER BY date_added
$activitySql = "SELECT activities.*, classes.class_name AS class_name, classes.subject AS subject
        FROM activities 
        INNER JOIN classes ON activities.class_id = classes.class_id 
        WHERE activities.teacher_idnum = $teacherID
        ORDER BY activities.date_added DESC
        LIMIT $activityStartingIndex, $activitiesPerPage"; // Use LIMIT and OFFSET in the query directly
$activityResult = mysqli_query($connection, $activitySql);

// Fetch total number of activities from the database
$totalActivitiesSql = "SELECT COUNT(*) AS total FROM activities";
$totalActivitiesResult = mysqli_query($connection, $totalActivitiesSql);
$totalActivitiesRow = mysqli_fetch_assoc($totalActivitiesResult);
$totalActivities = $totalActivitiesRow['total'];
$totalActivityPages = ceil($totalActivities / $activitiesPerPage);


if ($activityResult && mysqli_num_rows($activityResult) > 0) {
  echo '<div class="container">';
  echo '<h1>Activity List</h1>';
  echo '<table class="table table-bordered">';
  echo '<thead class="thead-dark">';
  echo '<tr>';
  echo '<th scope="col">Class Name</th>';
  echo '<th scope="col">Subject</th>';
  echo '<th scope="col">Activity Title</th>';
  echo '<th scope="col">Deadline</th>';
  echo '<th scope="col">Actions</th>';
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  while ($row = mysqli_fetch_assoc($activityResult)) {
    $id = $row['activity_id'];
    $className = $row['class_name']; // Get the class name
    $activityTitle = $row['activity_title'];
    $activityDesc = $row['activity_description'];
    $deadline = date('F j, Y g:i a', strtotime($row['deadline'])); // Format the deadline
    $subject = $row['subject'];

    // Display each activity row in the table
    echo '<tr>';
    echo '<td>' . $className . '</td>';
    echo '<td>' . $subject . '</td>';
    echo '<td>' . $activityTitle . '</td>';
    echo '<td>' . $deadline . '</td>';
    echo '<td>';
    echo '<a href="question_acts.php?id=' . $id . '" class="btn btn-success mr-2">Add Activity</a>';
    echo '<a href="submission_activity.php?id=' . $id . '" class="btn btn-secondary mr-2">Submission</a>';
    echo '<a href="update_activity.php?id=' . $id . '" class="btn btn-primary mr-2">Update</a>';
    echo '<button type="button" class="btn btn-danger mr-2 delete-activity-btn" data-activity-id="' . $id . '" data-toggle="modal" data-target="#modalactivitydelete">Delete</button>';

    echo '</td>';
    echo '</tr>';
  }

  echo '</tbody>';
  echo '</table>';

  // Pagination for activity list
  echo '<nav aria-label="Page navigation">';
  echo '<ul class="pagination justify-content-center">';
  if ($currentActivityPage > 1) {
    echo '<li class="page-item"><a class="page-link" href="?activity_page=' . ($currentActivityPage - 1) . '">Previous</a></li>';
  }
  for ($i = 1; $i <= $totalActivityPages; $i++) {
    echo '<li class="page-item ' . ($currentActivityPage == $i ? 'active' : '') . '"><a class="page-link" href="?activity_page=' . $i . '">' . $i . '</a></li>';
  }
  if ($currentActivityPage < $totalActivityPages) {
    echo '<li class="page-item"><a class="page-link" href="?activity_page=' . ($currentActivityPage + 1) . '">Next</a></li>';
  }
  echo '</ul>';
  echo '</nav>';

  echo '</div>';
} else {
  echo '<div class="container">';
  echo '<p style = "font-weight: bold; font-size: 24px">No Activity found. Click Assessment to Add Activity</p>';
  echo '</div>';
}
?>
<!-- Button to trigger the delete modal -->

<!-- Confirmation Modal -->
<div class="modal fade" id="modalactivitydelete" tabindex="-1" role="dialog" aria-labelledby="modalactivitydeleteLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalactivitydeleteLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this activity?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="DeleteButton">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    // Add event listener to the "Delete" buttons
    const deleteActivityButtons = document.querySelectorAll(".delete-activity-btn");
    const confirmDeleteButton = document.getElementById("DeleteButton");

    deleteActivityButtons.forEach(button => {
      button.addEventListener("click", function () {
        // Get the activity ID from the data attribute
        const activityId = this.getAttribute("data-activity-id");

        // Add a click event listener to the "Delete" button in the modal
        confirmDeleteButton.addEventListener("click", function () {
          // Send AJAX request to delete_activity.php to delete the activity
          const xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                  // Activity deleted successfully, reload the page
                  location.reload();
                } else {
                  // Display error message if deletion fails
                  alert("An error occurred while deleting the activity.");
                }
              } else {
                // Handle error if necessary
                alert("An error occurred while deleting the activity.");
              }
            }
          };
          xhr.open("GET", "delete_activity.php?id=" + activityId, true);
          xhr.send();
        });
      });
    });
  });
</script>