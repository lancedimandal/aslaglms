<?php

include "../admin/includes/header.php";



?>

<div class="container-fluid px-4">
    <div class="row mt-4"></div>

    <div class="row">
        <div class="col-md-12">
            <?php
            include('../admin/message.php');

            ?>
            <div class="card">

                <div class="card-header">
                    <h4>Add Teacher
                        <a href="../admin/view-teacher.php" class="btn btn-danger float-end">Back</a>
                    </h4>

                </div>
                <div class="card-body">

                    <form action="../admin/code_teacher.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Teacher ID</label>
                                <input type="text" name="teacher_idnum" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Full Name</label>
                                <input type="text" name="full_name" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="">First Name</label>
                                <input type="text" name="first_name" class="form-control">
                            </div>

                            
                            <div class="col-md-6 mb-3">
                                <label for="">Last Name</label>
                                <input type="text" name="last_name" class="form-control">
                            </div>

                            
                            <div class="col-md-6 mb-3">
                                <label for="">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" id="email" onBlur=""
                                    class="form-control checking_teach_email" placeholder="Enter Email" required>
                                <small class="error_email" style="color:red;"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Type of Employement</label>
                                <select name="type_of_employment" id="type_of_employment" class="form-control" required>
                                    <option value="">-- Choose Type of Employment --</option>
                                    <option value="FULL TIME">FULL TIME</option>
                                    <option value="PART TIME">PART TIME</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Department</label>
                                <select name="department" id="department" class="form-control" required>
                                    <option value="">-- Choose Department --</option>
                                    <option value="IT Department">IT Department</option>
                                    <option value="EDUC Department">EDUC Department</option>
                                    <option value="AIS Department">AIS Department</option>
                                    <option value="BA Department">BA Department</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="add_teacher" class="btn btn-primary">Add
                                    Teacher</button>
                            </div>
                        </div>
                    </form>



                </div>
            </div>
        </div>

    </div>
</div>

<?php
include "../admin/includes/footer.php";
include "../admin/includes/scripts.php";
?>