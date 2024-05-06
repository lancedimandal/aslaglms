<?php

include "../admin/includes/header.php";


?>

<div class="container-fluid px-4">
    <h1 class="mt-4">CCSFP LMS - ADMIN</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    <div class="row">
        <div class="dash-content">
            <h1>Students</h1>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Total Registered Students
                    <?php
                    require_once "../config/connection.php";
                    $dash_students_query = "SELECT * FROM students";
                    $dash_students_query_run = mysqli_query($connection, $dash_students_query);
                    if ($students_total = mysqli_num_rows($dash_students_query_run)) {
                        echo '<h4 class="mb-0">' . $students_total . '</h4>';
                    } else {
                        echo '<h4 class="mb-0"> No Data </h4>';

                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Information Technology Students
                    <?php
                    require_once "../config/connection.php";

                    // Count the number of BSIT Students
                    $query = "SELECT COUNT(*) AS it_count FROM students WHERE course = 'BSIT'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $itCount = $row['it_count'];

                    echo '<h4 class="mb-0">' . $itCount . '</h4>';
                    ?>

                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Business Administration Students
                    <?php
                    require_once "../config/connection.php";

                    // Count the number of Financial Marketing Students
                    $query = "SELECT COUNT(*) AS fm_count FROM students WHERE course = 'BSBA-FM'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $fmCount = $row['fm_count'];

                    // Count the number of Marketing Management Students
                    $query = "SELECT COUNT(*) AS mm_count FROM students WHERE course = 'BSBA-MM'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $mmCount = $row['mm_count'];

                    // Count the number of Human Resource Management Students
                    $query = "SELECT COUNT(*) AS hrm_count FROM students WHERE course = 'BSBA-HRM'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $hrmCount = $row['hrm_count'];

                    // Count the number of Operations Management Students
                    $query = "SELECT COUNT(*) AS om_count FROM students WHERE course = 'BSBA-OM'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $omCount = $row['om_count'];

                    // Count the total number of BSBA Students
                    $totalbsba = ($fmCount + $mmCount + $hrmCount + $omCount);

                    echo '<h4 class="mb-0">' . $totalbsba . '</h4>';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Education Students
                    <?php
                    require_once "../config/connection.php";

                    // Count the number of General Science Students
                    $query = "SELECT COUNT(*) AS gs_count FROM students WHERE course = 'BSED-General Science'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $gsCount = $row['gs_count'];

                    // Count the number of Mathematics Students
                    $query = "SELECT COUNT(*) AS math_count FROM students WHERE course = 'BSED-Mathematics'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $mathCount = $row['math_count'];

                    // Count the number of English Students
                    $query = "SELECT COUNT(*) AS eng_count FROM students WHERE course = 'BSED-English'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $engCount = $row['eng_count'];

                    // Count the number of Elementary Education Students
                    $query = "SELECT COUNT(*) AS eed_count FROM students WHERE course = 'BEED'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $eedCount = $row['eed_count'];

                    $totaleduc = ($gsCount + $mathCount + $engCount + $eedCount);

                    echo '<h4 class="mb-0">' . $totaleduc . '</h4>';
                    ?>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">Accounting Information System Students
                    <?php
                    require_once "../config/connection.php";

                    // Count the number of Accounting Information Systems Students
                    $query = "SELECT COUNT(*) AS ais_count FROM students WHERE course = 'BSAIS'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $aisCount = $row['ais_count'];

                    echo '<h4 class="mb-0">' . $aisCount . '</h4>';
                    ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="dash-content">
                <h1>Teachers</h1>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-black mb-4">
                    <div class="card-body">Total Registered Teachers
                        <?php
                        require_once "../config/connection.php";

                        $dash_teachers_query = "SELECT * FROM teachers";
                        $dash_teachers_query_run = mysqli_query($connection, $dash_teachers_query);

                        if ($teachers_total = mysqli_num_rows($dash_teachers_query_run)) {
                            echo '<h4 class="mb-0">' . $teachers_total . '</h4>';
                        } else {
                            echo '<h4 class="mb-0"> No Data </h4>';

                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-black mb-4">
                    <div class="card-body">Part-Time
                    <?php
                    require_once ("..\config\connection.php");

                    // Count the number of part-time teachers
                    $query = "SELECT COUNT(*) AS parttime_count FROM teachers WHERE type_of_employment = 'PART TIME'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $parttimeCount = $row['parttime_count'];

                    echo '<h4 class="mb-0">' . $parttimeCount . '</h4>';

                    // Display the total number of full-time and part-time teachers

                    ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-black mb-4">
                    <div class="card-body">Full-Time
                    <?php
                    require_once ("..\config\connection.php");

                    // Count the number of full-time teachers
                    $query = "SELECT COUNT(*) AS fulltime_count FROM teachers WHERE type_of_employment = 'FULL TIME'";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_assoc($result);
                    $fulltimeCount = $row['fulltime_count'];

                    echo '<h4 class="mb-0">' . $fulltimeCount . '</h4>';



                    // Display the total number of full-time and part-time teachers

                    ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="dash-content">
                    <h1>Users</h1>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Admins
                            <?php
                            require_once "../config/connection.php";

                            $dash_admin_query = "SELECT * FROM admin";
                            $dash_admin_query_run = mysqli_query($connection, $dash_admin_query);

                            if ($admin_total = mysqli_num_rows($dash_admin_query_run)) {
                                echo '<h4 class="mb-0">' . $admin_total . '</h4>';
                            } else {
                                echo '<h4 class="mb-0"> No Data </h4>';

                            }


                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <?php

        include "../admin/includes/footer.php";
        include "../admin/includes/scripts.php";
        ?>