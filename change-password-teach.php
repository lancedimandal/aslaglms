<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <title>Document</title>
</head>

<body>

</body>

</html>
<?php
require 'config/connection.php';

if (isset($_GET['teacher_id']) && is_numeric($_GET['teacher_id'])) {
    $teacherID = $_GET['teacher_id'];
} else {
    echo "Invalid teacher ID!";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check the current password against the stored hashed password
    $checkQuery = "SELECT password FROM teachers WHERE teacher_idnum = ?";
    $checkStmt = mysqli_prepare($connection, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "i", $teacherID);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Verify the entered current password with the stored hash
            if (password_verify($currentPassword, $row['password'])) {
                if ($newPassword === $confirmPassword) {
                    // Hash the new password before updating
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $updateQuery = "UPDATE teachers SET password = ? WHERE teacher_idnum = ?";
                    $updateStmt = mysqli_prepare($connection, $updateQuery);
                    mysqli_stmt_bind_param($updateStmt, "si", $hashedPassword, $teacherID);

                    // Execute the update statement
                    if (mysqli_stmt_execute($updateStmt)) {
                        echo '<script>
                        Swal.fire({
                            title: "Success",
                            text: "Password updated successfully!",
                            icon: "success"
                        }).then(function() {
                            window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
                        });
                    </script>';
                    } else {
                        echo '<script>
                            Swal.fire({
                                title: "Error",
                                text: "Failed to update password. Please try again later.",
                                icon: "error"
                            }).then(function() {
                                window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
                            });
                        </script>';
                    }
                } else {
                    echo '<script>
                        Swal.fire({
                            title: "Error",
                            text: "Passwords do not match!",
                            icon: "error"
                        }).then(function() {
                            window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
                        });
                    </script>';
                }
            } else {
                echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Current password is incorrect!",
                        icon: "error"
                    }).then(function() {
                        window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
                    });
                </script>';
            }
        } else {
            echo '<script>
                Swal.fire({
                    title: "Error",
                    text: "No user found!",
                    icon: "error"
                }).then(function() {
                    window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
                });
            </script>';
        }
    } else {
        echo '<script>
            Swal.fire({
                title: "Error",
                text: "Database error: ' . mysqli_error($connection) . '",
                icon: "error"
            }).then(function() {
                window.location.href = "view-profile-teach.php?teacher_id=' . $teacherID . '";
            });
        </script>';
    }

    // Close the database connection
    mysqli_close($connection);
}
?>