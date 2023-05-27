<?php
// Start the session (if not already started)
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connect to the MySQL database
    $servername = "localhost";
    $usernameDB = "root";
    $passwordDB = "Passwd@123";
    $database = "cyclology";

    $conn = new mysqli($servername, $usernameDB, $passwordDB, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to retrieve the admin details based on the username
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row["password"];

        // Verify the password
        if ($password === $hashedPassword) {
            // Successful login
            $_SESSION["admin_username"] = $username;
            header("Location: admin_panel.php");
            exit();
        } else {
            // Incorrect password
            $message = "Wrong Password";
            $alertClass = "alert-danger";
        }
    } else {
        // User not found
        $message = "User-ID not found";
        $alertClass = "alert-warning";
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php if (isset($message)): ?>
      <div class="container mt-4">
        <div class="alert <?php echo $alertClass; ?>" role="alert">
            <?php echo $message; ?>
        </div>
</div>
    <?php endif; ?>
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
          <a class="nav-link" href="cadence85.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="login.php">Admin Login</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>
    <div class="container mt-5">
        <h1 class="text-center">Admin Login</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Log in</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
