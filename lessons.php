<style>
    #view-les,
    .delete-lesson {
        border-radius: 20px;
    }
</style>

<?php
require_once 'config/connection.php';

if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Validate the classID parameter (Optional - Depending on your use case)
    if (!is_numeric($classID)) {
        echo '<p>Invalid class ID.</p>';
        exit();
    }

    $selectQuery = "SELECT * FROM lessons WHERE class_id = ?";
    $stmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $classID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        while ($lesson = mysqli_fetch_assoc($result)) {
            echo '<div class="lesson-details">';
            echo '<img src="' . $lesson['lesson_image'] . '" alt="Lesson Image">';
            echo '<h2>' . $lesson['lesson_title'] . '</h2>';
            echo '<p>' . $lesson['lesson_description'] . '</p>';

            // Adding the view link
            echo '<a id="view-les" href="view-lessons.php?class_id=' . $classID . '&lesson_id=' . $lesson['lesson_id'] . '" class="btn btn-info">View lesson</a>';

            // Adding the delete link with SweetAlert confirmation
            echo '<a id="delete-les" href="#" class="btn btn-danger delete-lesson" data-class-id="' . $classID . '" data-lesson-id="' . $lesson['lesson_id'] . '">Delete lesson</a>';

            echo '</div>';
        }
    } else {
        echo '<p style="margin-top: 50px; margin-left: 20px;">No lessons found for this class.</p>';
    }

} else {
    echo '<p>Class ID not found.</p>';
}
?>

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Attach click event to all delete lesson links
        const deleteLinks = document.querySelectorAll(".delete-lesson");
        deleteLinks.forEach(link => {
            link.addEventListener("click", function (event) {
                event.preventDefault(); // Prevent the link from actually navigating

                const classID = this.getAttribute("data-class-id");
                const lessonID = this.getAttribute("data-lesson-id");

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to recover this lesson!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // User confirmed, proceed with deletion
                        window.location.href = 'delete-lesson.php?class_id=' + classID + '&lesson_id=' + lessonID;
                    }
                });
            });
        });
    });
</script>
