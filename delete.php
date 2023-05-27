<?php
session_start();

// Check if the admin_username session variable is set
if (!isset($_SESSION["admin_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<?php // Check if the participant ID is provided in the GET request
if (isset($_GET["phone"])) {
    $participantId = $_GET["phone"];

    // Connect to the MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "Passwd@123";
    $database = "cyclology";

    $conn = new mysqli($servername, $username, $password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query
    $participantId = $conn->real_escape_string($participantId);
    $query = "DELETE FROM participants WHERE phone = '$participantId'";

    // Execute the query
    if ($conn->query($query) === true) {
        // Redirect back to the admin panel page after successful deletion
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Error deleting participant: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the participant ID is not provided, redirect back to the admin panel page
    header("Location: admin_panel.php");
    exit();
}
?>
