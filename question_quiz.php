<?php
// Assuming you have already connected to your database here.
require 'config/connection.php';

// Check if the quiz ID is provided in the URL
if (!isset($_GET["id"])) {
  die("Error: Quiz ID not provided in the URL.");
}

$quiz_id = $_GET["id"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $question_type = $_POST["question_type"];
  $question_text = $_POST["question_text"];
  $score = $_POST[$question_type . "_score"];

  if (empty($question_type) || empty($question_text) || empty($score)) {
    die("Error: All fields are required.");
  }

  // Get the sum of scores for all questions in the current quiz
  $query_sum_scores = "SELECT SUM(score) FROM quiz_questions WHERE quiz_id = ?";
  $stmt_sum_scores = $connection->prepare($query_sum_scores);
  $stmt_sum_scores->bind_param("i", $quiz_id);
  $stmt_sum_scores->execute();
  $stmt_sum_scores->bind_result($total_question_scores);
  $stmt_sum_scores->fetch();
  $stmt_sum_scores->close();

  // Get the total score allowed for the quiz from the database
  $query_total_score = "SELECT total_points FROM quiz WHERE quiz_id = ?";
  $stmt_total_score = $connection->prepare($query_total_score);
  $stmt_total_score->bind_param("i", $quiz_id);
  $stmt_total_score->execute();
  $stmt_total_score->bind_result($total_quiz_score);
  $stmt_total_score->fetch();
  $stmt_total_score->close();

  if (($total_question_scores + $score) > $total_quiz_score) {
    die("Error: Total question scores exceed total quiz score.");
  }

  // Generate a unique identifier for the question
  $unique_identifier = $question_type . '_' . md5($question_text);

  // Check if a question with the same unique identifier exists in the quiz
  $stmt_check_duplicate = $connection->prepare("SELECT COUNT(*) FROM quiz_questions WHERE quiz_id = ? AND unique_identifier = ?");
  $stmt_check_duplicate->bind_param("is", $quiz_id, $unique_identifier);
  $stmt_check_duplicate->execute();
  $stmt_check_duplicate->bind_result($duplicate_count);
  $stmt_check_duplicate->fetch();
  $stmt_check_duplicate->close();

  if ($duplicate_count > 0) {
    die("Question Already Exists");
  }

  $display_order = mt_rand();

  $params = [$quiz_id, $question_type, $question_text, $score, $display_order, $unique_identifier];

  if ($question_type === "true_false") {
    $truefalse_correct_answer = $_POST["truefalse_correct_answer"];
    $params[] = $truefalse_correct_answer;
  } elseif ($question_type === "multiple_choice") {
    $choice_a = $_POST["choice_a"];
    $choice_b = $_POST["choice_b"];
    $choice_c = $_POST["choice_c"];
    $choice_d = $_POST["choice_d"];
    $multiple_choice_correct_answer = $_POST["multiple_choice_correct_answer"];
    $params = array_merge($params, [$multiple_choice_correct_answer, $choice_a, $choice_b, $choice_c, $choice_d]);
  } elseif ($question_type === "essay") {
    // Additional code for essay questions
  } else {
    die("Error: Invalid question type.");
  }

  $placeholders = implode(',', array_fill(0, count($params), '?'));

  $query = "INSERT INTO quiz_questions (quiz_id, question_type, question_text, score, display_order, unique_identifier";

  if ($question_type === "true_false") {
    $query .= ", correct_answer";
  } elseif ($question_type === "multiple_choice") {
    $query .= ", correct_answer, choice_a, choice_b, choice_c, choice_d";
  }

  $query .= ") VALUES ($placeholders)";

  $stmt_insert_question = $connection->prepare($query);

  $param_types = str_repeat('s', count($params));

  $bind_params = array_merge([$param_types], $params);
  $bind_params_ref = [];
  foreach ($bind_params as $key => $value) {
    $bind_params_ref[$key] = &$bind_params[$key];
  }
  call_user_func_array(array($stmt_insert_question, 'bind_param'), $bind_params_ref);

  if (!$stmt_insert_question->execute()) {
    die("Error: An error occurred while adding the question.");
  }

  $stmt_insert_question->close();

  echo "success";
  exit();
}
?>




<!DOCTYPE html>
<html>

<head>
  <title>Question Quiz</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>

<body>

  <header>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid d-flex justify-content-between align-items-center" id="ti">
        <div>
          <h1 style="font-size: 24px;">CCSFP Learning Management System Teacher Portal</h1>
        </div>
        <div>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <a href="teach-dash.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>
      </div>
    </nav>
  </header>

  <style>
    /* CSS Styles */
    #truefalse #highlightable {
      padding: 10px;
      margin: 5px;
      cursor: pointer;
      border: 1px solid #ccc;
    }

    #truefalse #highlightable.selected {
      background-color: #ddd;
    }

    body {
      background-color: white;
    }
  </style>



  <div class="container mt-4">
    <div class="row">
      <!-- Add Exam Question Form -->
      <div class="col-md-6 mt-10" style="margin-left: -50px;">
        <form id="quizForm" action="" method="post" enctype="multipart/form-data">
          <h1 style="text-align:center">Quiz QUESTION</h1>
          <div class="form-group">
            <label for="question_type">Choose Question Type:</label>
            <select name="question_type" id="question_type" class="form-control">
              <option value="">Type of Question</option>
              <option value="true_false">True/False</option>
              <option value="essay">Essay</option>
              <option value="multiple_choice">Multiple Choice</option>
            </select>
          </div>

          <div class="form-group">
            <label for="question_text">Question Text:</label>
            <textarea name="question_text" id="question_text" rows="4" cols="50" class="form-control"></textarea>
          </div>

          <div id="truefalse" style="display: none;">
            <br>
            <div class="form-group">
              <label for="truefalse_correct_answer">Correct Answer:</label>
              <select class="form-control" name="truefalse_correct_answer" id="truefalse_correct_answer">
                <option value="true">TRUE</option>
                <option value="false">FALSE</option>
              </select>
            </div>
            <div class="form-group">
              <label for="truefalse_score">Score for True/False:</label>
              <input type="number" name="true_false_score" class="form-control">
            </div>
            <br>
            <input type="submit" value="Submit" class="btn btn-primary">
          </div>

          <div id="multipleChoiceOptions" style="display: none;">
            <div class="form-group">
              <label for="choice_a">Choice A:</label>
              <input type="text" name="choice_a" class="form-control">
            </div>
            <div class="form-group">
              <label for="choice_b">Choice B:</label>
              <input type="text" name="choice_b" class="form-control">
            </div>
            <div class="form-group">
              <label for="choice_c">Choice C:</label>
              <input type="text" name="choice_c" class="form-control">
            </div>
            <div class="form-group">
              <label for="choice_d">Choice D:</label>
              <input type="text" name="choice_d" class="form-control">
            </div>
            <div class="form-group">
              <label for="multiple_choice_correct_answer">Correct Answer (A, B, C, or D):</label>
              <input type="text" name="multiple_choice_correct_answer" class="form-control">
            </div>
            <div class="form-group">
              <label for="multiple_choice_score">Score for Multiple Choice:</label>
              <input type="number" name="multiple_choice_score" class="form-control">
            </div>
            <input type="submit" value="Submit" class="btn btn-primary">
          </div>

          <div id="essayOptions" style="display: none;">
            <div class="form-group">
              <label for="essay_score">Score for Essay:</label>
              <input type="number" name="essay_score" class="form-control">
            </div>
            <input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
            <input type="submit" value="Submit" class="btn btn-primary">
          </div>
          <br>
        </form>
      </div>



      <!-- Exam Question List -->
      <div class="col-md-6 mt-10">
        <div class="exam-quest-list">

          <h1>QUIZ Question List</h1>

          <?php
          require 'config/connection.php';

          // Check if the exam ID is provided in the URL
          if (!isset($_GET["id"])) {
            die("Error: Quiz ID not provided in the URL.");
          }

          $quiz_id = $_GET["id"];

          // Define the number of questions to display per page
          $questionsPerPage = 4;

          // Get the current page number from the URL
          $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
          $current_page = max(1, $current_page); // Ensure page number is not less than 1
          
          // Fetch the total number of questions for the specific exam in the database
          $totalQuestionsSql = "SELECT COUNT(*) as total FROM quiz_questions WHERE quiz_id = $quiz_id";
          $totalQuestionsResult = mysqli_query($connection, $totalQuestionsSql);
          $totalQuestionsRow = mysqli_fetch_assoc($totalQuestionsResult);
          $totalQuestions = $totalQuestionsRow['total'];

          // Calculate the total number of pages
          $totalPages = ceil($totalQuestions / $questionsPerPage);

          // Calculate the offset for the SQL query
          $offset = ($current_page - 1) * $questionsPerPage;

          // Fetch exam questions from the database with pagination
          $sql = "SELECT * FROM quiz_questions WHERE quiz_id = $quiz_id LIMIT $offset, $questionsPerPage";
          $result = mysqli_query($connection, $sql);

          // Check if there are any questions in the database
          if (mysqli_num_rows($result) > 0) {
            $questionNumber = $offset + 1; // Adjust question number for the current page
          
            while ($row = mysqli_fetch_assoc($result)) {
              $questionText = $row['question_text'];
              $questionType = $row['question_type'];
              $correctAnswer = $row['correct_answer'];
              $score = $row['score'];
              $choiceA = $row['choice_a'];
              $choiceB = $row['choice_b'];
              $choiceC = $row['choice_c'];
              $choiceD = $row['choice_d'];
              $essayFilePath = $row['essay_file_path'];

              echo '<div class="question-container">';
              // Display the question number and text
              echo '<p>' . $questionNumber . '.) ' . $questionText . ' (' . $score . ' points)</p>';

              // Display options based on question type
              if ($questionType === 'multiple_choice') {
                echo '<p>A. ' . $choiceA . '</p>';
                echo '<p>B. ' . $choiceB . '</p>';
                echo '<p>C. ' . $choiceC . '</p>';
                echo '<p>D. ' . $choiceD . '</p>';

                // Highlight the correct answer
                if ($correctAnswer === 'a' || $correctAnswer === "A") {
                  echo '<p class="highlight">Correct Answer: A</p>';
                } elseif ($correctAnswer === 'b' || $correctAnswer === 'B') {
                  echo '<p class="highlight">Correct Answer: B</p>';
                } elseif ($correctAnswer === 'c' || $correctAnswer === 'C') {
                  echo '<p class="highlight">Correct Answer: C</p>';
                } elseif ($correctAnswer === 'd' || $correctAnswer === 'D') {
                  echo '<p class="highlight">Correct Answer: D</p>';
                }
              } elseif ($questionType === 'essay') {
                // Mark essay questions to be checked
          
              } elseif ($questionType === 'true_false') {
                // Display True/False options
                echo '<p>True</p>';
                echo '<p>False</p>';

                // Highlight the correct answer
                if ($correctAnswer === 'true') {
                  echo '<p class="highlight">Correct Answer: True</p>';
                } elseif ($correctAnswer === 'false') {
                  echo '<p class="highlight">Correct Answer: False</p>';
                }
              }


              echo '<br>';
              $questionNumber++;
            }

            // Add previous, next, and number of pages
            $prevPage = $current_page - 1;
            $nextPage = $current_page + 1;

            echo '<ul class="pagination">';
            if ($current_page > 1) {
              echo '<li class="page-item"><a class="page-link" href="?id=' . $quiz_id . '&page=' . $prevPage . '">Previous</a></li>';
            }


            echo '<li class="page-item"><span class="page-link">Page ' . $current_page . ' of ' . $totalPages . '</span></li>';

            if ($current_page < $totalPages) {
              echo '<li class="page-item"><a class="page-link" href="?id=' . $quiz_id . '&page=' . $nextPage . '">Next</a></li>';
            }
            echo '</ul>';

          } else {
            echo 'No questions found.';
          }

          // Close the database connection
          mysqli_close($connection);
          ?>

          <style>
            .highlight {

              color: green;
            }

            .question-actions {
              display: flex;
              align-items: center;
            }
          </style>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal for Success Message -->
  <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel"
    aria-hidden="true">
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
  <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel"
    aria-hidden="true">
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
  <!-- Add this script section in your HTML file (usually at the end before the closing </body> tag) -->
  <script>
    $(document).ready(function () {
      // Submit form using AJAX
      $("#quizForm").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
          type: "POST",
          data: new FormData(this),
          processData: false,
          contentType: false,
          success: function (response) {
            if (response === "success") {
              // Show the success modal
              $("#successModal").modal("show");
            } else {
              // Show the error modal with the error message
              $("#errorModal .modal-body").html(response);
              $("#errorModal").modal("show");
            }
          },
          error: function (xhr, status, error) {
            // Show the error modal with a generic error message
            $("#errorModal .modal-body").html("An error occurred. Please try again later.");
            $("#errorModal").modal("show");
          }
        });
      });

      // Redirect to the exam list page after closing the success modal
      $("#successModal").on("hidden.bs.modal", function () {
        window.location.href = "question_quiz.php?id=<?php echo $quiz_id; ?>";
      });
    });
  </script>




  <!-- Include Bootstrap and JavaScript -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // JavaScript code to show/hide additional options based on the selected question type
    const questionTypeSelect = document.getElementById('question_type');
    const trueFalseOptions = document.getElementById('truefalse');
    const multipleChoiceOptions = document.getElementById('multipleChoiceOptions');
    const essayOptions = document.getElementById('essayOptions');

    questionTypeSelect.addEventListener('change', function () {
      const selectedOption = questionTypeSelect.value;

      if (selectedOption === 'multiple_choice') {
        multipleChoiceOptions.style.display = 'block';
        essayOptions.style.display = 'none';
        trueFalseOptions.style.display = 'none';
      } else if (selectedOption === 'essay') {
        multipleChoiceOptions.style.display = 'none';
        essayOptions.style.display = 'block';
        trueFalseOptions.style.display = 'none';
      } else if (selectedOption === 'true_false') {
        multipleChoiceOptions.style.display = 'none';
        essayOptions.style.display = 'none';
        trueFalseOptions.style.display = 'block';
      } else {
        multipleChoiceOptions.style.display = 'none';
        essayOptions.style.display = 'none';
        trueFalseOptions.style.display = 'none';
      }
    });

    // JavaScript function for highlighting elements
    function highlight(element) {
      const elements = document.querySelectorAll('#truefalse #highlightable');
      elements.forEach((el) => el.classList.remove('selected'));
      element.classList.add('selected');
    }
  </script>

</body>

</html>