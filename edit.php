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
    $query = "SELECT * FROM participants WHERE phone = '$participantId'";

    // Execute the query
    $result = $conn->query($query);

    // Fetch the participant details
    if ($result->num_rows > 0) {
        $participant = $result->fetch_assoc();
    } else {
        // If no participant found, redirect back to the admin panel page
        header("Location: admin_panel.php");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    // If the participant ID is not provided, redirect back to the admin panel page
    header("Location: admin_panel.php");
    exit();
} ?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Participant</title>
    <!-- Include necessary CSS libraries -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="cadence85.php">
      <img src="cadence85.png" alt="Logo" width="160" height="97" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>
    <div class="container">
        <h2>Edit Participant</h2>
        <form action="update.php?phone=<?php echo $participant[
            "phone"
        ]; ?>" class="row g-3 p-3" method="post">
            <div class="col-md-4">
            <label for="name" class="form-label">Name*</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" aria-label="Name" value="<?php echo $participant[
                "name"
            ]; ?>" required>
            </div>
            <div class="col-md-4">
            <label for="age" class="form-label">Age*</label>
            <select id="inputname" name="age" class="form-select form-control" required>
            <option>Choose...</option>
            <?php for ($i = 14; $i <= 75; $i++) {
                $selected = $participant["age"] == $i ? "selected" : "";
                echo '<option value="' .
                    $i .
                    '" ' .
                    $selected .
                    ">" .
                    $i .
                    "</option>";
            } ?>
            </select>
            </div>

            <div class="col-md-4">
            <label for="gender" class="form-label">Gender*:</label>
            <select id="inputname" name="gender" class="form-select form-control" required>
            <?php
            $selected = $participant["gender"] == "Male" ? "selected" : "";
            echo '<option value="Male"' . $selected . ">Male</option>";
            $selected = $participant["gender"] == "Female" ? "selected" : "";
            echo '<option value="Female"' . $selected . ">Female</option>";
            $selected = $participant["gender"] == "Others" ? "selected" : "";
            echo '<option value="Others"' . $selected . ">Others</option>";
            ?>
            </select>
            </div>

            <div class="col-12">
            <label for="address" class="form-label">Address*</label>
            <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Enter Address" value="<?php echo $participant[
                "address"
            ]; ?>" required>
            </div>



            <div class="col-md-6">
            <label for="inputAddress" class="form-label">City/District*</label>
            <input type="text" class="form-control" name="city" id="inputAddress" placeholder="Enter City" value="<?php echo $participant[
                "city"
            ]; ?>" required>
            </div>

            <div class="col-md-6">
            <label for="inputZip" class="form-label">Pincode*</label>
            <input type="number" class="form-control" pattern="[0-9]" name="zip" id="inputZip" placeholder="Enter Pincode" value="<?php echo $participant[
                "pincode"
            ]; ?>" required>
            </div>

            <div class="col-md-4">
            <label for="club" class="form-label">Club / team</label>
            <input type="text" class="form-control" name="club" id="inputname" placeholder="Enter Club" value="<?php echo $participant[
                "club"
            ]; ?>">
            </div>

            <div class="col-md-4">
            <label for="mobile" class="form-label">Phone*</label>
            <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter Phone No." value="<?php echo $participant[
                "phone"
            ]; ?>" disabled>
            </div>

            <div class="col-md-4">
            <label for="email" class="form-label">Email*</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?php echo $participant[
                "email"
            ]; ?>" required>
            <span id="email_result"></span>
            </div>

            <div class="col-md-6">
            <label for="bloodgroup" class="form-label">Blood group</label>
            <select id="inputname" name="bloodgroup" class="form-select form-control">
                <?php
                $selected =
                    $participant["blood_group"] == "A+" ? "selected" : "";
                echo '<option value="A+"' . $selected . ">A+</option>";
                $selected =
                    $participant["blood_group"] == "O+" ? "selected" : "";
                echo '<option value="O+"' . $selected . ">O+</option>";
                $selected =
                    $participant["blood_group"] == "B+" ? "selected" : "";
                echo '<option value="B+"' . $selected . ">B+</option>";
                $selected =
                    $participant["blood_group"] == "AB+" ? "selected" : "";
                echo '<option value="AB+"' . $selected . ">AB+</option>";
                $selected =
                    $participant["blood_group"] == "A-" ? "selected" : "";
                echo '<option value="A-"' . $selected . ">A-</option>";
                $selected =
                    $participant["blood_group"] == "O-" ? "selected" : "";
                echo '<option value="O-"' . $selected . ">O-</option>";
                $selected =
                    $participant["blood_group"] == "B-" ? "selected" : "";
                echo '<option value="B-"' . $selected . ">B-</option>";
                $selected =
                    $participant["blood_group"] == "AB-" ? "selected" : "";
                echo '<option value="AB-"' . $selected . ">AB-</option>";
                ?>
            </select>
            </div>

            <div class="col-md-3">
                    <label for="category" class="form-label">Category*:</label>
                    <select id="inputname" name="category" class="form-select form-control" required>
                        <?php
                        $selected =
                            $participant["category"] == "U-18"
                                ? "selected"
                                : "";
                        echo '<option value="U-18"' .
                            $selected .
                            ">U-18</option>";
                        $selected =
                            $participant["category"] == "Elite (18-35)"
                                ? "selected"
                                : "";
                        echo '<option value="Elite (18-35)"' .
                            $selected .
                            ">Elite (18-35)</option>";
                        $selected =
                            $participant["category"] == "Masters (35+)"
                                ? "selected"
                                : "";
                        echo '<option value="Masters (35+)"' .
                            $selected .
                            ">Masters (35+)</option>";
                        ?>
                    </select>
                    </div>

            <div class="col-md-6">
            <label for="typeofbike" class="form-label">Type of Bike*:</label>
            <select id="inputname" name="typeofbike" class="form-select form-control" required>
                <?php
                $selected =
                    $participant["bike_type"] == "Road / Hybrid"
                        ? "selected"
                        : "";
                echo '<option value="Road / Hybrid"' .
                    $selected .
                    ">Road / Hybrid</option>";
                $selected =
                    $participant["bike_type"] == "MTB" ? "selected" : "";
                echo '<option value="MTB"' . $selected . ">MTB</option>";
                ?>
            </select>
            </div>

            <div class="col-md-6">
            <label for="econtactname" class="form-label">Emergency contact name*</label>
            <input type="text" class="form-control" name="econtactname" placeholder="Enter  Emergency Contact Name" aria-label="Emergency contact name"  value="<?php echo $participant[
                "emergency_contact_name"
            ]; ?>" required>
            </div>

            <div class="col-md-6">
            <label for="econtactnumber" class="form-label">Emergency contact number*</label>
            <input type="number" class="form-control" pattern="[0-9]" name="econtactnumber" id="number" placeholder="Enter Contact Number" value="<?php echo $participant[
                "emergency_contact_number"
            ]; ?>" required>
            </div>
            <div class="col-md-6">
            <label for="payment" class="form-label">Payment Status*:</label>
            <select id="payment" name="payment" class="form-select form-control" required>
                <?php
                $selected =
                    $participant["payment"] == "unpaid" ? "selected" : "";
                echo '<option value="unpaid"' . $selected . ">Unpaid</option>";
                $selected = $participant["payment"] == "paid" ? "selected" : "";
                echo '<option value="paid"' . $selected . ">Paid</option>";
                ?>
            </select>
            </div>
            <div class="col-12 p-2">
            <button type="submit" id="submit" class="btn btn-primary" method="update.php">Edit</button>
            </div>
            <div class="col-12 p-2">
            <a href="admin_panel.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>