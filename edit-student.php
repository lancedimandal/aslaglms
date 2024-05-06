<?php

include "../admin/includes/header.php";



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Students</h1>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php
                include('../admin/message.php');

                ?>
                <div class="card-header">
                    <h4>Edit Student
                        <a href="../admin/view-student.php" class="btn btn-danger float-end">Back</a>
                    </h4>

                </div>
                <div class="card-body">
                    <?php
                    require_once "../config/connection.php";

                    if (isset($_GET['editid'])) {

                        $esid = $_GET['editid'];
                        $students = "SELECT * FROM students WHERE student_idnum='$esid'";
                        $student_run = mysqli_query($connection, $students);

                        if (mysqli_num_rows($student_run) > 0) {


                            foreach ($student_run as $students) {


                                ?>


                                <form action="../admin/code_student.php" method="POST">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Student ID</label>
                                            <input type="text" name="student_idnum" value="<?= $students['student_idnum']; ?>"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Username</label>
                                            <input type="text" name="username" value="<?= $students['username']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Full Name</label>
                                            <input type="text" name="full_name" value="<?= $students['full_name']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Email</label>
                                            <input type="text" name="email" value="<?= $students['email']; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Course</label>
                                            <select name="course" id="course" class="form-control" required>
                                                <option value="">-- Select Course --</option>
                                                <option value="BSBA-OM" <?= $students['course'] == 'BSBA-OM' ? 'selected' : '' ?>>
                                                    BSBA-OM</option>
                                                <option value="BSBA-HRM" <?= $students['course'] == 'BSBA-HRM' ? 'selected' : '' ?>>
                                                    BSBA-HRM</option>
                                                <option value="BSBA-FM" <?= $students['course'] == 'BSBA-FM' ? 'selected' : '' ?>>
                                                    BSBA-FM</option>
                                                <option value="BSBA-MM" <?= $students['course'] == 'BSBA-MM' ? 'selected' : '' ?>>
                                                    BSBA-MM</option>
                                                <option value="BSED-Mathematics" <?= $students['course'] == 'BSED-Mathematics' ? 'selected' : '' ?>>BSED-Mathematics</option>
                                                <option value="BSED-English" <?= $students['course'] == 'BSED-English' ? 'selected' : '' ?>>BSED-English</option>
                                                <option value="BSED-General Science" <?= $students['course'] == 'BSED-General Science' ? 'selected' : '' ?>>BSED-General Science</option>
                                                <option value="BEED" <?= $students['course'] == 'BEED' ? 'selected' : '' ?>>BEED
                                                </option>
                                                <option value="BSIT" <?= $students['course'] == 'BSIT' ? 'selected' : '' ?>>BSIT
                                                </option>
                                                <option value="BSAIS" <?= $students['course'] == 'BSAIS' ? 'selected' : '' ?>>BSAIS
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="">Year Level</label>
                                            <select name="year_level" id="year_level" class="form-control" required>
                                                <option value="">-- Select Year Level --</option>
                                                <option value="1" <?= $students['year_level'] == '1' ? 'selected' : '' ?>>1</option>
                                                <option value="2" <?= $students['year_level'] == '2' ? 'selected' : '' ?>>2</option>
                                                <option value="3" <?= $students['year_level'] == '3' ? 'selected' : '' ?>>3</option>
                                                <option value="4" <?= $students['year_level'] == '4' ? 'selected' : '' ?>>4</option>
                                            </select>

                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="section">Section</label>
                                            <select name="section" id="section" class="form-control" required>
                                                <option value="">-- Select Section --</option>
                                                <option value="A" <?= $students['section'] == 'A' ? 'selected' : '' ?>>A</option>
                                                <option value="B" <?= $students['section'] == 'B' ? 'selected' : '' ?>>B</option>
                                                <option value="C" <?= $students['section'] == 'C' ? 'selected' : '' ?>>C</option>
                                                <option value="D" <?= $students['section'] == 'D' ? 'selected' : '' ?>>D</option>
                                                <option value="E" <?= $students['section'] == 'E' ? 'selected' : '' ?>>E</option>
                                                <option value="F" <?= $students['section'] == 'F' ? 'selected' : '' ?>>F</option>
                                                <option value="G" <?= $students['section'] == 'G' ? 'selected' : '' ?>>G</option>
                                                <option value="H" <?= $students['section'] == 'H' ? 'selected' : '' ?>>H</option>
                                                <option value="I" <?= $students['section'] == 'I' ? 'selected' : '' ?>>I</option>
                                                <option value="J" <?= $students['section'] == 'J' ? 'selected' : '' ?>>J</option>
                                                <option value="K" <?= $students['section'] == 'K' ? 'selected' : '' ?>>K</option>
                                                <option value="L" <?= $students['section'] == 'L' ? 'selected' : '' ?>>L</option>
                                                <option value="M" <?= $students['section'] == 'M' ? 'selected' : '' ?>>M</option>
                                                <option value="N" <?= $students['section'] == 'N' ? 'selected' : '' ?>>N</option>
                                                <option value="O" <?= $students['section'] == 'O' ? 'selected' : '' ?>>O</option>
                                                <option value="P" <?= $students['section'] == 'P' ? 'selected' : '' ?>>P</option>
                                                <option value="Q" <?= $students['section'] == 'Q' ? 'selected' : '' ?>>Q</option>
                                                <option value="R" <?= $students['section'] == 'R' ? 'selected' : '' ?>>R</option>
                                                <option value="S" <?= $students['section'] == 'S' ? 'selected' : '' ?>>S</option>
                                                <option value="T" <?= $students['section'] == 'T' ? 'selected' : '' ?>>T</option>
                                                <option value="U" <?= $students['section'] == 'U' ? 'selected' : '' ?>>U</option>
                                                <option value="V" <?= $students['section'] == 'V' ? 'selected' : '' ?>>V</option>
                                                <option value="W" <?= $students['section'] == 'W' ? 'selected' : '' ?>>W</option>
                                                <option value="X" <?= $students['section'] == 'X' ? 'selected' : '' ?>>X</option>
                                                <option value="Y" <?= $students['section'] == 'Y' ? 'selected' : '' ?>>Y</option>
                                                <option value="Z" <?= $students['section'] == 'Z' ? 'selected' : '' ?>>Z</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Password</label>
                                            <input type="text" name="password" value="<?= $students['password']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" name="update_student" class="btn btn-primary">Update
                                                Student</button>
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