<?php

include "../admin/includes/header.php";



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Teachers</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Teachers</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?php
            include('../admin/message.php');

            ?>
            <div class="card">

                <div class="card-header">
                    <h4>Edit Teacher
                        <a href="../admin/view-teacher.php" class="btn btn-danger float-end">Back</a>
                    </h4>

                </div>
                <div class="card-body">
                    <?php
                    require_once "../config/connection.php";

                    if (isset($_GET['editid'])) {

                        $etid = $_GET['editid'];
                        $teachers = "SELECT * FROM teachers WHERE teacher_idnum='$etid'";
                        $teacher_run = mysqli_query($connection, $teachers);

                        if (mysqli_num_rows($teacher_run) > 0) {


                            foreach ($teacher_run as $teachers) {


                                ?>


                                <form action="../admin/code_teacher.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Teacher ID</label>
                                            <input type="text" name="teacher_idnum" value="<?= $teachers['teacher_idnum']; ?>"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Username</label>
                                            <input type="text" name="username" value="<?= $teachers['username']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Full Name</label>
                                            <input type="text" name="full_name" value="<?= $teachers['full_name']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Email</label>
                                            <input type="text" name="email" value="<?= $teachers['email']; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Type of Employment</label>
                                            <select name="type_of_employment" id="type_of_employment" class="form-control">
                                                <option value="">-- Choose Type of Employment --</option>
                                                <option value="FULL TIME" <?= $teachers['type_of_employment'] == 'FULL TIME' ? 'selected' : '' ?>>FULL TIME</option>
                                                <option value="PART TIME" <?= $teachers['type_of_employment'] == 'PART TIME' ? 'selected' : '' ?>>PART TIME</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Department</label>
                                            <select name="department" id="department" class="form-control">
                                                <option value="">-- Choose Department --</option>
                                                <option value="IT Department" <?= $teachers['department'] == 'IT Department' ? 'selected' : '' ?>>IT Department</option>
                                                <option value="EDUC Department" <?= $teachers['department'] == 'EDUC Department' ? 'selected' : '' ?>>EDUC Department</option>
                                                <option value="AIS Department" <?= $teachers['department'] == 'AIS Department' ? 'selected' : '' ?>>AIS Department</option>
                                                <option value="BA Department" <?= $teachers['department'] == 'BA Department' ? 'selected' : '' ?>>BA Department</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Password</label>
                                            <input type="text" name="password" value="<?= $teachers['password']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" name="update_teacher" class="btn btn-primary">Update
                                                Teacher</button>
                                        </div>
                                    </div>
                                </form>


                                <?php
                            }

                        } else {

                            ?>
                            <h4>No record found</h4>

                            <?php

                        }
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