<?php
if (isset($_GET['room_name'])) {
    $roomName = $_GET['room_name'];

    require('config/connection.php'); // Include your database connection code

    // Perform the delete operation
    $deleteQuery = "DELETE FROM room_links
                    WHERE room_name = ?";

    $stmt = $connection->prepare($deleteQuery);
    $stmt->bind_param("s", $roomName);

    if ($stmt->execute()) {
        $stmt->close();
        echo "success"; // Indicate successful deletion
    } else {
        echo "Error deleting room link: " . $connection->error;
    }
} else {
    echo "Invalid request.";
}
?>
