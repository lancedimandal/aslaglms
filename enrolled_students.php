<?php
// Include your database connection script
require 'config/connection.php';

function getEnrolledStudentsWithNames($connection, $offset, $limit, $classId = null) {
    $sql = "SELECT sc.enrollment_id, s.full_name AS student_name, s.email, s.student_idnum, s.course, s.year_level, s.section, sc.class_id, sc.enrollment_date
    FROM student_classes AS sc
    JOIN students AS s ON sc.student_id = s.student_idnum";


    if ($classId !== null) {
        // If a specific class filter is applied, include it in the query
        $sql .= " WHERE sc.class_id = $classId";
    }

    $sql .= " LIMIT $offset, $limit";

    $result = $connection->query($sql);

    $enrolledStudents = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $enrolledStudents[] = $row;
        }
    }

    return $enrolledStudents;
}

// Fetch the list of classes from the database
$classesSql = "SELECT class_id, class_name FROM classes";
$classesResult = $connection->query($classesSql);

$classes = array();

if ($classesResult->num_rows > 0) {
    while ($classRow = $classesResult->fetch_assoc()) {
        $classes[] = $classRow;
    }
}

// Function to get the total number of enrolled students
function getTotalEnrolledStudents($connection) {
    $sql = "SELECT COUNT(*) AS total_students FROM student_classes";

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['total_students'];
    }

    return 0;
}

// Determine the current page and records per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
$recordsPerPage = 10;

// Calculate the offset for pagination
$offset = ($page - 1) * $recordsPerPage;

// Get enrolled students with their names from the database
$enrolledStudents = getEnrolledStudentsWithNames($connection, $offset, $recordsPerPage);

// Get the total number of enrolled students for pagination
$totalStudents = getTotalEnrolledStudents($connection);

// Calculate the total number of pages
$totalPages = ceil($totalStudents / $recordsPerPage);

// Close the database connection
$connection->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enrolled Students</title>
    <style>
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: center;
        }

        .table thead th {
            background-color: #343a40;
            color: #fff;
            font-weight: bold;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #en-stud {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container" style = "margin-left: 10px;">
    <h1 class="mb-4" id="en-stud">Enrolled Students</h1>
    <div class="form-group">
<label for="class-filter">Filter by Class:</label>
<select id="class-filter" class="form-control">
    <option value="">All Classes</option> 
    <?php foreach  ($classes as $class)  { ?>
        <option value="<?php echo $class['class_id']; ?>"><?php echo $class['class_name']; ?></option>
    <?php } ?>
</select>
    </div>
    <div class="form-group">
        <label for="search">Search</label>
        <input type="search" class="form-control" id="search">
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year</th>
                <th>Section</th>
                <th>Enrollment Date</th>
            </tr>
            </thead>
            <tbody>
    <?php foreach ($enrolledStudents as $student) { ?>
        <tr data-class="<?php echo $student['class_id']; ?>">
            <td><?php echo $student['student_idnum']; ?></td>
            <td><?php echo $student['student_name']; ?></td>
            <td><?php echo $student['email']; ?></td>
            <td><?php echo $student['course']; ?></td>
            <td><?php echo $student['year_level']; ?></td>
            <td><?php echo $student['section']; ?></td>
            
            <td><?php echo date('F d, Y', strtotime($student['enrollment_date'])); ?></td>
        </tr>
    <?php } ?>
</tbody>
        </table>
    </div>
     <!-- Add pagination links -->
     <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>

<!-- Add JavaScript to handle the filtering and search -->
<script>
document.getElementById('class-filter').addEventListener('change', function() {
    var selectedClassId = this.value;
    var rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var dataClass = row.getAttribute('data-class');

        // If no class is selected (All Classes), show all rows; otherwise, show only matching rows
        if (selectedClassId === '' || selectedClassId === dataClass) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});

document.getElementById('search').addEventListener('input', function() {
    var searchValue = this.value.toLowerCase();
    var rows = document.querySelectorAll('tbody tr');

    rows.forEach(function(row) {
        var studentName = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
        var studentEmail = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        var studentID = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

        // If the search value matches any part of the student's name, email, or ID, show the row; otherwise, hide it
        if (studentName.includes(searchValue) || studentEmail.includes(searchValue) || studentID.includes(searchValue)) {
            row.style.display = 'table-row';
        } else {
            row.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
