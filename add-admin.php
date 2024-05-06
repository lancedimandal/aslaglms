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
                    <h4>Add Admin
                        <a href="../admin/view-admin.php" class="btn btn-danger float-end">Back</a>
                    </h4>

                </div>
                <div class="card-body">

                    <form action="../admin/code_admin.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Full Name</label>
                                <input type="text" name="fullname" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Email</label>
                                <input type="text" name="email"  class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="">Password</label>
                                <input type="text" name="password" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <button type="submit" name="add_admin" class="btn btn-primary">Add
                                    Admin</button>
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