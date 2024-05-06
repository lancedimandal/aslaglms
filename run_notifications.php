<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once 'config/connection.php'; // Include your database connection here
require 'vendor/autoload.php'; // Load Composer's autoloader for PHPMailer


try {
    // Get the current time
    date_default_timezone_set('Asia/Manila');

    $currentTime = time();
    $currentFormatted = date('Y-m-d H:i:s', $currentTime);


    // Query exams that are scheduled to occur in the future
    $scheduledExamsQuery = "SELECT * FROM exams WHERE scheduled_time >= ?";
    $scheduledStmt = mysqli_prepare($connection, $scheduledExamsQuery);
    mysqli_stmt_bind_param($scheduledStmt, "i", $currentTime);
    mysqli_stmt_execute($scheduledStmt);
    $result = mysqli_stmt_get_result($scheduledStmt);

    while ($row = mysqli_fetch_assoc($result)) {
        // Get the scheduled time for this exam
        $scheduledTime = strtotime($row['scheduled_time']);
        $scheduledFormatted = date('Y-m-d H:i:s', $scheduledTime);



        // Compare the current time with the scheduled time
        if ($currentFormatted >= $scheduledFormatted) {
            echo 'current time: ' . $currentFormatted . '<br>';
            echo 'scheduled: ' . $scheduledFormatted . '<br>';


            // Fetch the student emails for the class associated with this exam
            $studentEmailQuery = "SELECT students.email FROM students
                                  INNER JOIN student_classes ON students.student_idnum = student_classes.student_id
                                  WHERE student_classes.class_id = ?";
            $emailStmt = mysqli_prepare($connection, $studentEmailQuery);
            mysqli_stmt_bind_param($emailStmt, "i", $row['class_id']);
            mysqli_stmt_execute($emailStmt);
            $emailResult = mysqli_stmt_get_result($emailStmt);

            while ($emailRow = mysqli_fetch_assoc($emailResult)) {
                $studentEmail = $emailRow['email'];

                try {
                    // Create a PHPMailer instance
                    $mail = new PHPMailer(true);

                    // Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable debug output
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'aslaglmsccsfp@gmail.com';
                    $mail->Password = 'mkhymxhzbphobwcb';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    // Recipients
                    $mail->setFrom('aslaglmsccsfp@gmail.com', 'no-reply-System');
                    $mail->addAddress($studentEmail); // Add student's email as recipient

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Upcoming Exam';

                    // Prepare the email body based on exam occurrence
                    if ($currentTime == $scheduledTime) {
                        $mail->Body = 'You have an exam to view. Please click the link below:<br><br>';
                        $mail->Body .= '<a href="link_to_view_exam">Click here to view the exam</a>';
                    } else {
                        $mail->Body = 'You have an upcoming exam scheduled. Please be prepared!';
                    }

                    $mail->send();

                    echo "Email sent to: $studentEmail<br>"; // Debug output

                } catch (Exception $e) {
                    echo "Email could not be sent. Error: {$mail->ErrorInfo}<br>"; // Debug output
                }
            }

            mysqli_stmt_close($emailStmt);
        }
    }

    mysqli_stmt_close($scheduledStmt);
} catch (Exception $e) {
    // Handle exceptions
}
?>