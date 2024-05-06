<?php

include "../admin/includes/header.php";



?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Admin</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <?php
                include('../admin/message.php');

                ?>

                <div class="card-header">
                    <h4>Edit Admin
                        <a href="../admin/view-admin.php" class="btn btn-danger float-end">Back</a>
                    </h4>

                </div>
                <div class="card-body">
                    <?php
                    require_once "../config/connection.php";

                    if (isset($_GET['editid'])) {

                        $user_id = $_GET['editid'];
                        $admin = "SELECT * FROM admin WHERE id='$user_id'";
                        $admin_run = mysqli_query($connection, $admin);

                        if (mysqli_num_rows($admin_run) > 0) {


                            foreach ($admin_run as $admin) {


                                ?>


                                <form action="../admin/code_admin.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?=$admin['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Username</label>
                                            <input type="text" name="username" value="<?= $admin['username']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Full Name</label>
                                            <input type="text" name="fullname" value="<?= $admin['fullname']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Email</label>
                                            <input type="text" name="email" value="<?= $admin['email']; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="">Password</label>
                                            <input type="text" name="password" value="<?= $admin['password']; ?>"
                                                class="form-control">
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button type="submit" name="update_admin" class="btn btn-primary">Update
                                                Admin</button>
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