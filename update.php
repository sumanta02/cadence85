<?php
session_start();

// Check if the admin_username session variable is set
if (!isset($_SESSION["admin_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<?php
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check if the participant ID is provided in the GET request
if (isset($_GET["phone"])) {
    $name = sanitizeInput($_POST["name"]);
    $age = sanitizeInput($_POST["age"]);
    $gender = sanitizeInput($_POST["gender"]);
    $address = sanitizeInput($_POST["address"]);
    $city = sanitizeInput($_POST["city"]);
    $pincode = sanitizeInput($_POST["zip"]);
    $club = sanitizeInput($_POST["club"]);
    $phone = sanitizeInput($_GET["phone"]);
    $email = sanitizeInput($_POST["email"]);
    $bloodGroup = sanitizeInput($_POST["bloodgroup"]);
    $category = sanitizeInput($_POST["category"]);
    $bikeType = sanitizeInput($_POST["typeofbike"]);
    $emergencyContactName = sanitizeInput($_POST["econtactname"]);
    $emergencyContactNumber = sanitizeInput($_POST["econtactnumber"]);
    $payment = sanitizeInput($_POST["payment"]);

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
    $updateQuery = "UPDATE participants 
        SET name = '$name', age = '$age', gender = '$gender', address = '$address', city = '$city', pincode = '$pincode', club = '$club', email = '$email', blood_group = '$bloodGroup', category = '$category', bike_type = '$bikeType', emergency_contact_name ='$emergencyContactName', emergency_contact_number = '$emergencyContactNumber', payment = '$payment'
        WHERE phone = $phone";
    if ($conn->query($updateQuery) === true) {
        $message = "Participant data updated successfully!";
        $_SESSION["result"] = $message;
        $alertClass = "alert-success";
        $_SESSION["alert"] = $alertClass;
    } else {
        $message = "Error updating data: " . $conn->error;
        $_SESSION["result"] = $message;
        $alertClass = "alert-danger";
        $_SESSION["alert"] = $alertClass;
    }

    // Close the database connection
    $conn->close();
    header("Location: admin_panel.php");
    var_dump($_POST);
    exit();
} else {
    // If the participant ID is not provided, redirect back to the admin panel page
    header("Location: admin_panel.php");
    exit();
}

?>
