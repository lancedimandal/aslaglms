<?php
session_start();
require_once "../config/connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Function to check if email exists
function isEmailExists($connection, $email)
{
    $email = mysqli_real_escape_string($connection, $email);
    $email_query = "SELECT * FROM students WHERE email=?";
    $stmt = mysqli_prepare($connection, $email_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    return ($num_rows > 0);
}

function generate_password($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
}
$generated_password = generate_password();
if (isset($_POST['check_btn_submit'])) {
    $email = $_POST['email_id'];

    if (isEmailExists($connection, $email)) {
        echo "Email already exists.";
    } else {
        echo "Email available for registration.";
    }
}

if (isset($_POST['add_student'])) {
    $student_idnum = $_POST['student_idnum'];
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $password = $_POST['password'];

    $query = "INSERT INTO students (student_idnum,username,full_name,email,course,year_level,section,password) VALUES ('$student_idnum','$username','$full_name','$email','$course','$year_level','$section','$generated_password')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
   
        $_SESSION['message'] = "Student data added.";

        // Create an instance of PHPMailer; enable exceptions
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'corecrustlord@gmail.com';
            $mail->Password = 'jfadrqmnfdeqcvxu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('cocrecrustlord@gmail.com', 'AslagLMS Registrar');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your Student Portal Login Details';
            
            // Compose the message
            $message = "<html><body>";
            $message .= "<h2>Hello,</h2>";
            $message .= "<p>We are delighted to provide you with your login credentials for our student portal:</p>";
            $message .= "<p><strong>Student ID:</strong> " . $student_idnum . "</p>";
            $message .= "<p><strong>Password:</strong> " . $password . "</p>";
            $message .= "<p>To access the portal, please click on the link below:</p>";
            $message .= '<p><a href="http://localhost/aslaglms/student-login.php">Student Login Page</a></p>';
            $message .= "<p>This portal is your gateway to a world of educational resources, interactive learning, and collaboration. We are here to support your academic journey.</p>";
            $message .= "<p>If you encounter any issues or have questions, don't hesitate to contact our dedicated support team.</p>";
            $message .= "<p>Thank you for choosing us as your educational partner. We look forward to your successful learning experience.</p>";
            $message .= "<p>Best regards,<br>AslagLMS Registrar<br></p>";
            $message .= "</body></html>";
            
            $mail->Body = $message;
            

            // Send the email
            if (!$mail->send()) {
                echo 'Email could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Email has been sent';
            }
        } catch (Exception $e) {
            echo 'Email could not be sent. Mailer Exception: ', $e->getMessage();
        }


        header('Location:../admin/view-student.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Student data cannot be added.";
        header('Location:../admin/view-student.php');
        exit(0);
    }
}



if (isset($_POST['update_student'])) {
    $student_idnum = $_POST['student_idnum'];
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $year_level = $_POST['year_level'];
    $section = $_POST['section'];
    $password = $_POST['password'];

    $query = "UPDATE students SET username='$username',full_name='$full_name',email='$email',course='$course',year_level='$year_level',section='$section',password='$password' WHERE student_idnum='$student_idnum'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['message'] = "Student data updated.";
        header('Location:../admin/view-student.php');
        exit(0);
    }
}
if (isset($_POST['student_delete'])) {
    $student_idnum = $_POST['student_delete'];

    $query = "DELETE FROM students WHERE student_idnum = '$student_idnum' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['message'] = "Student deleted successfully";
        header('Location:../admin/view-student.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Student data cannot be deleted.";
        header('Location:../admin/view-student.php');
        exit(0);
    }
}

?>

