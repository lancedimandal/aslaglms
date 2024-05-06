<?php


// Check if the recent class IDs are available in the cookie
if (isset($_COOKIE['recent_classes'])) {
    // Retrieve the recently viewed class IDs from the cookie and unserialize them
    $recentClasses = json_decode($_COOKIE['recent_classes'], true);

    // Make sure $recentClasses is an array
    if (is_array($recentClasses)) {
        // Determine the total number of recently viewed classes
        $totalClasses = count($recentClasses);

        // Determine the current page number based on the 'page' query parameter
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

        // Define the number of recent views to display per page
        $viewsPerPage = 3;

        // Calculate the starting index for the current page
        $startIdx = ($currentPage - 1) * $viewsPerPage;

        // Calculate the ending index for the current page
        $endIdx = min($startIdx + $viewsPerPage, $totalClasses);

        // Output the container for the recent classes
        echo '<div class="container">';
        echo '<div class="row">';

        if ($totalClasses > 0) {
            for ($i = $startIdx; $i < $endIdx; $i++) {
                $classId = $recentClasses[$i];
            
                $selectQuery = "SELECT * FROM classes WHERE class_id = ?";
                $stmt = mysqli_prepare($connection, $selectQuery);
                mysqli_stmt_bind_param($stmt, "i", $classId);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
            
                if (mysqli_num_rows($result) > 0) {
                    // Display the most recently viewed class
                    $row = mysqli_fetch_assoc($result);
                    $subject = $row['subject'];
                    $schoolYear = $row['academic_year'];
                    $classImage = $row['class_image'];
                    $subject_id = $row['subject_id']; // Assuming the column name is 'subject_id'
                    $section_id = $row['section_id']; // Assuming the column name is 'section_id'
            
                            // Retrieve subject information based on subject_id
                    $subject_query = mysqli_query($connection, "SELECT * FROM subject WHERE subject_id = $subject_id");
                    $subject_data = mysqli_fetch_assoc($subject_query);
                    $subject_name = $subject_data['subject_description']; // Assuming the column name is 'subject_name'

                    // Retrieve section information based on section_id
                    $section_query = mysqli_query($connection, "SELECT * FROM sections WHERE id = $section_id");
                    $section_data = mysqli_fetch_assoc($section_query);
                    $section_name = $section_data['section']; // Assuming the column name is 'section_name'
            
                    echo '<div class="col-md-4">';
                    echo '<div class="recent-class">';
                    echo "<img src='" . $classImage . "' alt='Class Image' class='class-image'>";
                    echo '<p class="subject">' . $subject_name . '</p>';
                    echo '<p class="section">Section: ' . $section_name . '</p>';
                    echo '<p class="school-year">School Year: ' . $schoolYear . '</p>';
                 
                    echo '</div>';
                    echo '</div>';
                } else {
                    // The most recently viewed class no longer exists
                    echo '<div class="col-md-4">';
                    echo '<div class="recent-class">';
                    echo '<p class="error-message">One of the recently viewed classes does not exist.</p>';
                    echo '</div>';
                    echo '</div>';
                }
            }

            // Close the row and container for the recent classes
            echo '</div>';
            echo '</div>';

            // Display pagination buttons using Bootstrap classes
            echo '<div class="recent-pagination">';
            echo '<nav aria-label="Recent Class Pagination">';
            echo '<ul class="pagination justify-content-center">';

            if ($currentPage > 1) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a></li>';
            }

            for ($page = 1; $page <= ceil($totalClasses / $viewsPerPage); $page++) {
                $activeClass = ($page === $currentPage) ? ' active' : '';
                echo '<li class="page-item' . $activeClass . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
            }

            if ($endIdx < $totalClasses) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a></li>';
            } else {
                echo '<li class="page-item disabled"><span class="page-link">Next</span></li>';
            }

            echo '</ul>';
            echo '</nav>';
            echo '</div>';
        } else {
            // No recent class IDs available or the cookie is empty
            echo '<div class="col-12 text-center">';
            echo '<p class="error-message">No recent classes found.</p>';
            echo '</div>';
        }
    } else {
        // The recent_classes cookie does not contain an array
        echo '<div class="col-12 text-center">';
        echo '<p class="error-message">Invalid data in the recent_classes cookie.</p>';
        echo '</div>';
    }
} else {
    // No recent class IDs available or the cookie is empty
    echo '<div class="col-12 text-center">';
    echo '<p class="error-message">No recent classes found.</p>';
    echo '</div>';
}
?>

<style>
.recent-class {
    
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
    display: grid;
    grid-template-rows: 150px 1fr;
    grid-gap: 10px; ;
}
.recent-class p {
  
    line-height: 0.8;
    display: flex;
}

.recent-class .class-image {
    width:  247px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.recent-class h3 {
    font-size: 20px;
    font-weight: bold;
    margin-bottom: 10px;
}

.recent-class .subject,
.recent-class .school-year,
.recent-class .section {
    margin-bottom: 5px;

}


.recent-pagination {
    margin-top: 10px;
    margin-bottom: 50px;
}

/* Ensure consistent width for the buttons */
.recent-pagination .page-link {
    min-width: 120px;
}
</style>

