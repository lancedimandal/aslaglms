<?php
session_start();
require_once "../config/connection.php";

function isEmailExists($connection, $email)
{
    $email = mysqli_real_escape_string($connection, $email);
    $email_query = "SELECT * FROM teachers WHERE email=?";
    $stmt = mysqli_prepare($connection, $email_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    return ($num_rows > 0);
}

if (isset($_POST['check_btn_submit'])) {
    $email = $_POST['email_id'];

    if (isEmailExists($connection, $email)) {
        echo "Email already exists.";
    } else {
        echo "Email available for registration.";
    }
}

if(isset($_POST['add_teacher'])){
    $teacher_idnum = $_POST['teacher_idnum'];
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $type_of_employment = $_POST['type_of_employment'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $firstname= $_POST['first_name'];
    $lastname= $_POST['last_name'];
    $middlename= $_POST['middle_name'];

     // Hash the password
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $query ="INSERT INTO teachers (teacher_idnum,username,full_name,first_name,last_name,middle_name,email,type_of_employment,department,password) VALUES ('$teacher_idnum','$username','$full_name', '$firstname', '$lastname', '$middlename','$email','$type_of_employment','$department','$hashedPassword')";
     $query_run = mysqli_query($connection, $query);

    if($query_run){
        $_SESSION['message'] = "Teacher data added.";
        header('Location:../admin/view-teacher.php');
        exit(0);
    }
    else{
        $_SESSION['message'] = "Teacher data cannot added.";
        header('Location:../admin/view-teacher.php');
        exit(0);

    }

}

if (isset($_POST['update_teacher'])) {
    $teacher_idnum = $_POST['teacher_idnum'];
    $username = $_POST['username'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $type_of_employment = $_POST['type_of_employment'];
    $department = $_POST['department'];
    $password = $_POST['password'];
    $firstname= $_POST['first_name'];
    $lastname= $_POST['last_name'];
    $middlename= $_POST['middle_name'];

     // Hash the password
     $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

     $query = "UPDATE teachers SET username='$username',full_name='$full_name' first_name ='$firstname', last_name='$lastname', middle_name='$middlename',email='$email',type_of_employment='$type_of_employment',department='$department',password='$hashedPassword' WHERE teacher_idnum='$teacher_idnum'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['message'] = "Teacher data updated.";
        header('Location:../admin/view-teacher.php');
        exit(0);
    }
}
if (isset($_POST['teacher_delete'])) {
    $student_idnum = $_POST['teacher_delete'];

    $query = "DELETE FROM teachers WHERE teacher_idnum = '$teacher_idnum' ";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['message'] = "Teacher deleted successfully";
        header('Location:../admin/view-teacher.php');
        exit(0);
    } else {
        $_SESSION['message'] = "Teacher data cannot be deleted.";
        header('Location:../admin/view-teacher.php');
        exit(0);
    }
}

?>