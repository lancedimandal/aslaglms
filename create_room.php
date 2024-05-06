<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the submitted room name and create a unique room ID
    $roomName = $_POST['roomName'];
    $roomId = uniqid();

    // Save the room data in the database (you need to implement this)
    // For example: INSERT INTO rooms (room_id, room_name, host_username) VALUES ('$roomId', '$roomName', '{$_SESSION['username']}')

    // Generate the link for the created room
    $roomLink = "https://meet.jit.si/{$roomId}";
}
?>

<!DOCTYPE html>
<html>
<head><link rel="stylesheet" type="text/css" href="style.css">
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Create Jitsi Room</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>

    <main>
        <h2>Create a New Room</h2>
        <?php if (isset($roomLink)) { ?>
            <p>Room successfully created!</p>
            <p>Room Name: <?php echo $roomName; ?></p>
            <p>Room Link: <a href="<?php echo $roomLink; ?>" target="_blank"><?php echo $roomLink; ?></a></p>
        <?php } else { ?>
            <form method="post">
                <label for="roomName">Room Name:</label>
                <input type="text" id="roomName" name="roomName" required>
                <button type="submit">Create Room</button>
            </form>
        <?php } ?>
        <h2>Join an Existing Room</h2>
        <form action="join_room.php" method="get">
            <label for="roomLink">Room Link:</label>
            <input type="text" id="roomLink" name="roomLink" placeholder="Paste the room link here" required>
            <button type="submit">Join Room</button>
        </form>
    </main>

</body>
</html>