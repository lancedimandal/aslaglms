<?php
// Assuming you have already connected to your database here.
require 'config/connection.php';

// Check if the assignment ID is provided in the URL
if (!isset($_GET["id"])) {
    die("Error: Assignment ID not provided in the URL.");
}

$assignment_id = $_GET["id"];

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question_text = $_POST["question_text"];

    // Use prepared statements to prevent SQL injection
    $stmt_insert_question = $connection->prepare("INSERT INTO ass_questions (assignment_id, question_text) VALUES (?, ?)");

    if (!$stmt_insert_question) {
        die("Error: " . $connection->error);
    }

    $stmt_insert_question->bind_param("is", $assignment_id, $question_text);

    if (!$stmt_insert_question->execute()) {
        die("Error: An error occurred while adding the question.");
    }

    // If everything is successful, return a JSON response indicating success
    echo json_encode(array("success" => true));
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assignment Question</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">
            Assignment Question
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
            <a href="teach-dash.php" class="btn btn-secondary">Back to Dashboard</a>
            </ul>
        </div>
    </div>
</nav>

<body>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <h1>Add Question to Assignment</h1>
            <form id="questionForm" action="" method="post">
                <div class="form-group">
                    <label for="question_text">Question Text:</label>
                    <textarea name="question_text" id="question_text" rows="4" cols="50" class="form-control" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary" id="addQuestionBtn">Add Question</button>
            </form>
        </div>
        <div class="col-md-6 mt-10" style="margin-left: 0">

            <div> <h1 class="text-center">Assignment Question List</h1></div>
            <?php
                require 'config/connection.php';

                // Check if the assignment ID is provided in the URL
                if (!isset($_GET["id"])) {
                    die("Error: Assignment ID not provided in the URL.");
                }

                $assignmentId = $_GET["id"];
                // Define the number of questions to display per page
                $questionsPerPage = 4;

                // Get the current page number from the URL
                $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
                $current_page = max(1, $current_page); // Ensure page number is not less than 1

                // Fetch the total number of questions in the database for the specified assignment
                $totalQuestionsSql = "SELECT COUNT(*) as total FROM ass_questions WHERE assignment_id = $assignmentId";
                $totalQuestionsResult = mysqli_query($connection, $totalQuestionsSql);
                $totalQuestionsRow = mysqli_fetch_assoc($totalQuestionsResult);
                $totalQuestions = $totalQuestionsRow['total'];

                // Calculate the total number of pages
                $totalPages = ceil($totalQuestions / $questionsPerPage);

                // Calculate the offset for the SQL query
                $offset = ($current_page - 1) * $questionsPerPage;

                // Fetch assignment questions from the database with pagination
                $sql = "SELECT * FROM ass_questions WHERE assignment_id = $assignmentId LIMIT $offset, $questionsPerPage";
                $result = mysqli_query($connection, $sql);

                // Check if there are any questions in the database
                if (mysqli_num_rows($result) > 0) {
                    $questionNumber = $offset + 1; // Adjust question number for the current page

                    while ($row = mysqli_fetch_assoc($result)) {
                        $questionText = $row['question_text'];
                        echo '<div class="question-container">';
                        // Display the question number and text
                        echo '<p>' . $questionNumber . '.) ' . $questionText . '</p>';

                        // Action buttons for "Update" and "Delete"
                        echo '<div class="question-actions">';
                        echo '<a href="update_question.php?id=' . $row['question_id'] . '" class="btn btn-info btn-sm">Update</a>';
                        echo '<a href="delete_question.php?id=' . $row['question_id'] . '" class="btn btn-danger btn-sm ml-2">Delete</a>';
                        echo '</div>';

                        echo '</div>'; // Close the question container

                        echo '<br>';

                        $questionNumber++;
                    }
                    // Add previous, next, and number of pages
                    $prevPage = $current_page - 1;
                    $nextPage = $current_page + 1;

                    echo '<ul class="pagination">';
                    if ($current_page > 1) {
                        echo '<li class="page-item"><a class="page-link" href="?id=' . $assignmentId . '&page=' . $prevPage . '">Previous</a></li>';
                    }

                    echo '<li class="page-item"><span class="page-link">Page ' . $current_page . ' of ' . $totalPages . '</span></li>';

                    if ($current_page < $totalPages) {
                        echo '<li class="page-item"><a class="page-link" href="?id=' . $assignmentId . '&page=' . $nextPage . '">Next</a></li>';
                    }
                    echo '</ul>';

                } else {
                    echo 'No questions found.';
                }

                // Close the database connection
                mysqli_close($connection);
                ?>
            </div>
        </div>
        </div>
<!-- Modal for Success Message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Question added successfully!
            </div>
            <div class="modal-footer">
                <a href="javascript:location.reload();" class="btn btn-primary">OK</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Error Message -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Error adding question. Please try again later.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
<!-- Add Bootstrap JS and jQuery scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Place the script section at the end of the <body> section, after the form -->
<script>
    // Wait for the document to be ready
    document.addEventListener('DOMContentLoaded', function () {
        // Get the form element
        const form = document.getElementById('questionForm');

        // Add a submit event listener to the form
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent form submission

            // Submit the form data using AJAX
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show the success modal
                        $('#successModal').modal('show');
                    } else {
                        // Show the error modal
                        $('#errorModal').modal('show');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show the error modal in case of any error
                    $('#errorModal').modal('show');
                });
        });
    });
</script>
</body>
</html>
