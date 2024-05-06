<!DOCTYPE html>
<html>
<head>
  <style>
    /* Custom CSS Styles */
    body {
      font-family: Arial, sans-serif;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
    }

    .nav-tabs {
      margin-top: 30px;
      list-style: none;
      padding: 0;
      display: flex;
      justify-content: center;
    }

    .nav-item {
      margin-right: 10px;
    }

    .nav-link {
      text-decoration: none;
      color: #333;
      font-weight: bold;
      padding: 5px;
      border-bottom: 2px solid transparent;
      transition: border-bottom-color 0.3s ease;
    }

    .nav-link.active {
      border-bottom-color: #333;
    }

    .tab-content {
      margin-top: 20px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    .modal-title {
      font-weight: bold;
    }

    .modal-body .form-group {
      margin-bottom: 10px;
    }

    .modal-body .form-group label {
      display: block;
      font-weight: bold;
    }

    .modal-footer {
      text-align: right;
      margin-top: 20px;
    }

    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      text-decoration: none;
      border: none;
      border-radius: 4px;
      transition: background-color 0.3s ease;
    }

    .btn-primary {
      background-color: #007bff;
    }

    .btn-secondary {
      background-color: #6c757d;
    }

    .btn-primary:hover,
    .btn-secondary:hover {
      background-color: #0056b3;
    }

    .quiz-list-item {
      margin-bottom: 20px;
      border: 1px solid #ccc;
      padding: 10px;
      border-radius: 5px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Assignment/Exam/Activity/Quiz Management System</h1>
    <hr>
    <ul class="nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#assignments">Assignments</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#exams">Exams</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#activities">Activities</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#quizzes">Quizzes</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane container active" id="assignments">
        <!-- Assignment Management Section -->
      </div>
      <div class="tab-pane container fade" id="exams">
        <!-- Exam Management Section -->
      </div>
      <div class="tab-pane container fade" id="activities">
        <!-- Activity Management Section -->
      </div>
      <div class="tab-pane container fade" id="quizzes">
        <h2>Quizzes</h2>
        <hr>
        <button type="button" class="btn btn-primary" id="addQuizBtn">Add Quiz</button>
        <div id="quizList">
          <!-- Quiz List Section -->
        </div>
      </div>
    </div>
  </div>

  <!-- Add Quiz Modal -->
  <div class="modal" id="addQuizModal">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addQuizModalLabel">Add Quiz</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="quizTitle">Quiz Title:</label>
          <input type="text" class="form-control" id="quizTitle">
        </div>
        <div class="form-group">
          <label for="quizDescription">Quiz Description:</label>
          <textarea class="form-control" id="quizDescription" rows="4"></textarea>
        </div>
        <div class="form-group">
          <label for="quizQuestions">Quiz Questions:</label>
          <textarea class="form-control" id="quizQuestions" rows="4"></textarea>
        </div>
        <div class="form-group">
          <label for="questionType">Question Type:</label>
          <select class="form-control" id="questionType">
            <option value="true_false">True or False</option>
            <option value="multiple_choice">Multiple Choice</option>
            <option value="fill_in_the_blank">Fill in the Blank</option>
          </select>
        </div>
        <div id="questionOptions" style="display: none;">
          <div class="form-group">
            <label for="option1">Option 1:</label>
            <input type="text" class="form-control" id="option1">
          </div>
          <div class="form-group">
            <label for="option2">Option 2:</label>
            <input type="text" class="form-control" id="option2">
          </div>
          <!-- Add more option fields as needed -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveQuizBtn">Save Quiz</button>
      </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#questionType').change(function() {
        var selectedType = $(this).val();
        if (selectedType === 'multiple_choice') {
          $('#questionOptions').show();
        } else {
          $('#questionOptions').hide();
        }
      });

      $('#addQuizBtn').click(function() {
        $('#addQuizModal').css('display', 'block');
      });

      $('.close').click(function() {
        $('#addQuizModal').css('display', 'none');
      });

      $('#saveQuizBtn').click(function() {
        var quizTitle = $('#quizTitle').val();
        var quizDescription = $('#quizDescription').val();
        var quizQuestions = $('#quizQuestions').val();
        var questionType = $('#questionType').val();
        var option1 = $('#option1').val();
        var option2 = $('#option2').val();
        // Handle saving the quiz data and adding it to the quiz list
        // You can use AJAX or other methods to send the data to the server
        // and update the quiz list dynamically
        // Example code for adding the quiz to the quiz list:
        var quizListItem = $('<div class="quiz-list-item"><h4>' + quizTitle + '</h4><p>' + quizDescription + '</p></div>');
        $('#quizList').append(quizListItem);
        // Reset form fields
        $('#quizTitle').val('');
        $('#quizDescription').val('');
        $('#quizQuestions').val('');
        $('#questionType').val('true_false');
        $('#option1').val('');
        $('#option2').val('');
        $('#questionOptions').hide();
        $('#addQuizModal').css('display', 'none');
      });
    });
  </script>
</body>
</html>
