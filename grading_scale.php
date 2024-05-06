<?php
function getGradeFromPercentage($percentage) {
    // Define your grading scale here
    // Example: Associative array with percentage ranges and their corresponding grades
    $grading_scale = array(
        95 => 'A+',
        90 => 'A',
        85 => 'A-',
        80 => 'B+',
        75 => 'B',
        70 => 'B-',
        65 => 'C+',
        60 => 'C',
        55 => 'C-',
        50 => 'D',
        0 => 'F'
    );

    // Ensure the percentage is within the valid range (0 to 100)
    $percentage = max(0, min(100, $percentage));

    // Find the appropriate grade based on the percentage
    $grade = 'F'; // Default grade if the percentage is below 60 (D)
    foreach ($grading_scale as $score => $letter_grade) {
        if ($percentage >= $score) {
            $grade = $letter_grade;
            break;
        }
    }

    return $grade;
}

?>
