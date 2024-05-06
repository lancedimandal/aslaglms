<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="../admin/js/jquery.dataTables.min.js"></script>
<script src="../admin/js/dataTables.bootstrap5.min.js"></script>

<script src="js/scripts.js"></script>
<script src="js/datatables-simple-demo.js"></script>

<script>
        // Check if the alert session variable is set
        var alertMessage = "<?php echo isset($_SESSION['alert']) ? $_SESSION['alert'] : ''; ?>";
        if (alertMessage !== '') {
            alert(alertMessage); // Display the alert
        }

        // Clear the alert session variable
        <?php unset($_SESSION['alert']); ?>
    </script>

</body>



</html>