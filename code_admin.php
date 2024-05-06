<?php
session_start();
require_once "../config/connection.php";

if (isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query = "INSERT INTO admin (username, fullname, email, password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $fullname, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Admin data added.";
    } else {
        $_SESSION['message'] = "Admin data cannot be added.";
    }

    mysqli_stmt_close($stmt);
    header('Location:../admin/view-admin.php');
    exit(0);
}

if (isset($_POST['update_admin'])) {
    $id = $_POST['user_id']; // Assuming the ID is submitted through a hidden input field named "admin_id"
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $query = "UPDATE admin SET username=?, fullname=?, email=?, password=? WHERE id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "ssssi", $username, $fullname, $email, $password, $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Admin data updated.";
    } else {
        $_SESSION['message'] = "Admin data cannot be updated.";
    }

    mysqli_stmt_close($stmt);
    header('Location:../admin/view-admin.php');
    exit(0);
}

if (isset($_POST['admin_delete'])) {
    $id = $_POST['admin_delete'];

    // Use prepared statements to prevent SQL injection
    $query = "DELETE FROM admin WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Admin deleted successfully";
    } else {
        $_SESSION['message'] = "Admin data cannot be deleted.";
    }

    mysqli_stmt_close($stmt);
    header('Location:../admin/view-admin.php');
    exit(0);
}
?>