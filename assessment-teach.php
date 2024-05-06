<?php 

require 'config/connection.php';

?>

<style>

  .teacher-assessment {

    position: absolute !important;
    top: 15%;
    left: 20%;
    width: auto;
  

  }

  .teacher-assessment form {

    box-sizing: border-box;
    border: 1px solid black;
    padding: 20px;

  }

  .teacher-assessment #ass-type{


    background-color: #4CAF50;
    color: #fff;
    padding: 5px 10px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  

  }

  .teacher-assessment select {

    text-align: center;
    padding: 5px 10px;
    font-size: 15px;
  }

</style>


<div class="teacher-assessment">
  <form>
    <label for="examType">Assessment Type:</label>
    <select id="examType" name="examType">
        <option value="" disabled selected>Select Type</option>
        <option value="quiz">Quiz</option>
        <option value="exam">Exam</option>
        <option value="activity">Activity</option>
        <option value="assignment">Assignment</option>
    </select>
    <br><br>
  </form>

<div class = "add_quiz" style = "display:none">
 <div class = "quiz-content">
    <div class = "q-title">
        <label for="quiz-title">Quiz Title: </label>
        <input type="text" name = "quiz-title" placeholder="Quiz Title" required>
    </div>
    <div class = "q-desc">

        <label for="quiz-description">Quiz Description: </label>
        <input type="text" name = "quiz-desc" placeholder = "Quiz Description" required>
    </div>
    <div>
        <button type = "submit" name = "add-quiz" id = "add-quiz">Save</button>
        <button class = "back">Back</button>
    </div>
 </div>
</div>


</div>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    var examTypeSelect = document.getElementById('examType');
    var teachAddQuizContent = document.getElementById('type-of-assessment');

    // Function to handle option selection
    function handleOptionSelection() {
      var selectedOption = examTypeSelect.value;
      if (selectedOption === 'quiz') {
        teachAddQuizContent.style.display = 'block'; // Show add_quiz.php content
      } else {
        teachAddQuizContent.style.display = 'none'; // Hide add_quiz.php content
      }
    }

    // Add event listener to the examTypeSelect element
    examTypeSelect.addEventListener('change', handleOptionSelection);

    // Check the selected option on page load
    handleOptionSelection();
  });
</script>







