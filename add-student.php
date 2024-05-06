<?php

include "../admin/includes/header.php";

?>

<?php
function generate_password($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[random_int(0, strlen($characters) - 1)];
    }
    return $password;
}

$generated_password = generate_password();

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
                    <h4>Add Student
                        <a href="../admin/view-student.php" class="btn btn-danger float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="../admin/code_student.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Student ID</label>
                                <input type="text" name="student_idnum" class="form-control" placeholder="Enter Student ID" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter Username">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Full Name</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email" id="email" onBlur=""
                                    class="form-control checking_stud_email" placeholder="Enter Email" required>
                                <small class="error_email" style="color:red;"></small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="course">Course</label>
                                <select name="course" id="course" class="form-control" required>
                                <option value="">Select A Course</option>
                                    <option value="BSBA-OM">BSBA Major in Operation Management</option>
                                    <option value="BSBA-HRM">BSBA Major in Human Resource Management</option>
                                    <option value="BSBA-FM">BSBA Major in Financial Marketing</option>
                                    <option value="BSBA-MM">BSBA Major in Marketing Management</option>
                                    <option value="BSED-MATH">BSED Major in Mathematics</option>
                                    <option value="BSED-ENG">BSED Major in English</option>
                                    <option value="BSED-SCI">BSED Major in Science</option>
                                    <option value="BEED">Bachelor of Elementary Education</option>
                                    <option value="BSIT">BS in Information Technology</option>
                                    <option value="BS-AIS">BS in Accounting Information System</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Year Level</label>
                                <select name="year_level" id="year_level" class="form-control" required>
                                    <option value="">Select Year Level</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Section</label>
                                <select name="section" id="section" class="form-control" required>
                                    <option value="">Select Section</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                    <option value="E">E</option>
                                    <option value="F">F</option>
                                    <option value="G">G</option>
                                    <option value="H">H</option>
                                    <option value="I">I</option>
                                    <option value="J">J</option>
                                    <option value="K">K</option>
                                    <option value="L">L</option>
                                    <option value="M">M</option>
                                    <option value="N">N</option>
                                    <option value="O">O</option>
                                    <option value="P">P</option>
                                    <option value="Q">Q</option>
                                    <option value="R">R</option>
                                    <option value="S">S</option>
                                    <option value="T">T</option>
                                    <option value="U">U</option>
                                    <option value="V">V</option>
                                    <option value="W">W</option>
                                    <option value="X">X</option>
                                    <option value="Y">Y</option>
                                    <option value="Z">Z</option>
                                </select>
                                <div class="col-md-6 mb-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                            
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" required value="<?php echo $generated_password; ?>">
                                    <div class="input-group-append">
                                        <button type="button" id="showPassword" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                                            <i class="fa fa-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="add_student" class="btn btn-primary">Add
                                    Student</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        }
    }
</script>
<?php
include "../admin/includes/footer.php";
include "../admin/includes/scripts.php";
?>