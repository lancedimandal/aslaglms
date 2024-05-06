
<?php
require_once 'config/connection.php';

// Check if the class ID is provided in the URL parameter
if (isset($_GET['class_id'])) {
    $classID = $_GET['class_id'];

    // Fetch the class details from the database
    $selectQuery = "SELECT class_name, subject FROM classes WHERE class_id = ?";
    $stmt = mysqli_prepare($connection, $selectQuery);
    mysqli_stmt_bind_param($stmt, "i", $classID);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $classData = mysqli_fetch_assoc($result);
        $className = $classData['class_name'];
        $subject = $classData['subject'];
    } else {
        // No class found with the given class_id
        echo '<p>Class not found.</p>';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title><?php echo $className; ?>  Subject: <?php echo $subject; ?></title>

    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-----CALENDAR--------->
    <!-- CSS for full calender -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">

<style>
    /* Set the background color for the navigation bar */
    .navbar {
        background-color: #001c3f; /* Dark blue color */

    }

    /* Set the text color for the navigation bar links */
    .navbar .navbar-brand,
    .navbar .nav-link {
        color: #fff; /* White text color */
    }

    /* Set the color for the search button */
    .navbar .btn-primary {
        background-color: #3949ab; /* Darker blue color for the search button */
        border-color: #3949ab;
    }

    /* Set the color for the dropdown menu items */
    .navbar .dropdown-item {
        color: #000; /* Black text color for dropdown items */
        
    }

    /* Set the background color for the dropdown menu on hover */
    .navbar .dropdown-menu a:hover {
        background-color: #0d47a1; /* Slightly darker blue on hover */
        color: #fff; /* White text color on hover */
    }

    /* Set the color for the user icon in the dropdown menu */
    .navbar .fas.fa-user.fa-fw {
        color: #fff; /* White color for the user icon */
    }

    #sidebarToggle {
        
        display:none;
    }

   
</style>

<nav class="sb-topnav navbar navbar-expand">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="#"><?php echo $className; ?> - <?php echo $subject; ?></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"> <i class="fas fa-bars"></i> </button>

            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#!">View Profile</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="../admin/logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    <div id="layoutSidenav_content">
        <main>

