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

// Define the number of announcements to display per page
$announcementsPerPage = 4;

// Get the current page number from the query string
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1; // Default to the first page
}

// Calculate the starting index of the announcements to fetch from the database
$startingIndex = ($currentPage - 1) * $announcementsPerPage;

// Fetch announcement data from the database with LIMIT and OFFSET, including class_name
$sql = "SELECT announcements.*, classes.class_name AS class_name 
        FROM announcements 
        INNER JOIN classes ON announcements.class_id = classes.class_id 
        WHERE announcements.teacher_id = $teacherID
        ORDER BY announcements.date_created DESC
        LIMIT $announcementsPerPage OFFSET $startingIndex";
$result = mysqli_query($connection, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="container">';
    echo '<h1>Announcement List</h1>';
    echo '<table class="table table-bordered">';
    echo '<thead class="thead-dark">';
    echo '<tr>';
    echo '<th scope="col">Class Name</th>'; // Added class name column
    echo '<th scope="col">Announcement Title</th>';
    echo '<th scope="col">Announcement Content</th>';
    echo '<th scope="col">Date Created</th>';
    echo '<th scope="col">Expiry Date</th>';
    echo '<th scope="col">Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['announcement_id'];
        $className = $row['class_name']; // Get the class name
        $announcementTitle  = $row['title'];
        $announcementContent = $row['content'];
        $dateCreated = date('F j, Y g:i a', strtotime($row['date_created'])); // Format the date created
        $expiryDate = date('F j, Y', strtotime($row['expiry_date'])); // Format the expiry date

        // Display each announcement row in the table
        echo '<tr>';
        echo '<td>' . $className . '</td>'; // Display the class name
        echo '<td>' . $announcementTitle . '</td>';
        echo '<td>' . $announcementContent . '</td>';
        echo '<td>' . $dateCreated . '</td>';
        echo '<td>' . $expiryDate . '</td>';
        echo '<td>';
        // Update button with link to the update_announcement.php page and passing the announcement ID as a parameter
        echo '<a href="update_announcement.php?id=' . $id . '" class="btn btn-primary mr-2">Update</a>';
        // Delete button with link to the delete_announcement.php page and passing the announcement ID as a parameter
        echo '<button type="button" class="btn btn-danger mr-2 delete-announce-btn" data-announce-id="' . $id . '" data-toggle="modal" data-target="#modalannouncedelete">Delete</button>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</table>';

    // Pagination
    $totalAnnouncementsSql = "SELECT COUNT(*) AS total FROM announcements WHERE teacher_id = $teacherID";
    $totalAnnouncementsResult = mysqli_query($connection, $totalAnnouncementsSql);
    $totalAnnouncementsRow = mysqli_fetch_assoc($totalAnnouncementsResult);
    $totalAnnouncements = $totalAnnouncementsRow['total'];
    $totalPages = ceil($totalAnnouncements / $announcementsPerPage);

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
    echo '<p style="font-weight: bold; font-size: 24px">No announcements found.</p>';
    echo '</div>';
}
?>

<!-- Confirmation Modal -->
<div class="modal fade" id="modalannouncedelete" tabindex="-1" role="dialog" aria-labelledby="modalannouncedeleteLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalannouncedeleteLabel">Confirm Deletion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this activity?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="DeleteButtonannounce">Delete</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    // Add event listener to the "Delete" buttons
    const deleteActivityButtons = document.querySelectorAll(".delete-announce-btn");
    const confirmDeleteButton = document.getElementById("DeleteButtonannounce");

    deleteActivityButtons.forEach(button => {
      button.addEventListener("click", function() {
        // Get the activity ID from the data attribute
        const announceID = this.getAttribute("data-announce-id");

        // Add a click event listener to the "Delete" button in the modal
        confirmDeleteButton.addEventListener("click", function() {
          // Send AJAX request to delete_activity.php to delete the activity
          const xhr = new XMLHttpRequest();
          xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
              if (xhr.status === 200) {
                // Parse the JSON response
                const response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                  // Activity deleted successfully, reload the page
                  location.reload();
                } else {
                  // Display error message if deletion fails
                  alert("An error occurred while deleting the Announcement.");
                }
              } else {
                // Handle error if necessary
                alert("An error occurred while deleting the Announcement.");
              }
            }
          };
          xhr.open("GET", "delete_announcement.php?id=" + announceID, true);
          xhr.send();
        });
      });
    });
  });
</script>