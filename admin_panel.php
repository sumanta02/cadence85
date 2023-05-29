<?php
session_start();

// Check if the admin_username session variable is set
if (!isset($_SESSION["admin_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Panel</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    html{

scroll-behavior: smooth;

}

@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,300;1,400;1,500&display=swap');

body{
font-family: 'Roboto', 'sans-serif';
}

</style>
</head>
<body>
<?php
session_start();
if (isset($_SESSION["result"])) {
    $message = $_SESSION["result"];
    $alertClass = $_SESSION["alertClass"];
    unset($_SESSION["result"]);
    unset($_SESSION["alertClass"]);

    echo '<div class="alert ' . $alertClass . '" role="alert">' . $message . "</div>";
}
?>
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
            <a class="nav-link" href="upload.php">Upload Images</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>
  <div class="container mt-5">
    <h4>Welcome, <?php echo $_SESSION["admin_username"]; ?> </h4>
    <!-- Admin panel content goes here -->
    <div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-6 p-2">
            <form method="GET" class="form-inline float-right">
                <div class="form-group">
                    <label for="phone">Search by Phone:</label>
                    <input type="text" class="form-control ml-2" id="phone" name="phone" placeholder="Enter phone number">
                </div>
                <button type="submit" class="btn btn-primary ml-2">Search</button>
                <?php if (isset($_GET["phone"])): ?>
                    <a href="admin_panel.php" class="btn btn-secondary ml-2">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

<?php // Check if the phone number is provided in the GET request
if (isset($_GET["phone"])) {
    $phone = $_GET["phone"];

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
    $phone = $conn->real_escape_string($phone);
    $query = "SELECT * FROM participants WHERE phone = '$phone'";

    // Execute the query
    $result = $conn->query($query);

    // Display the search results
    if ($result->num_rows > 0) {
        $count = 1;
        echo "<div class='container mt-4'>";
        echo "<h2>Search Results:</h2>";
        echo "<table class='table'>";
        echo "<thead><tr><th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Payment Status</th></tr></thead>";
        echo "<tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $count . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["payment"] . "</td>";
            echo "</tr>";
            $count++;
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    } else {
        echo "<div class='container mt-4'>";
        echo "<p>No results found.</p>";
        echo "</div>";
    }

    // Close the database connection
    $conn->close();
} ?>

<div class="container">
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Club</th>
                <th>Bike Type</th>
                <th>Phone Number</th>
                <th>Payment Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
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
            $query =
                "SELECT name, club, bike_type, phone, payment FROM participants";

            // Execute the query
            $result = $conn->query($query);

            // Display the participant details in the table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    $name = $row["name"];
                    $club = $row["club"];
                    $bikeType = $row["bike_type"];
                    $phone = $row["phone"];
                    $payment = $row["payment"];
                    ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $club; ?></td>
                        <td><?php echo $bikeType; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $payment; ?></td>
                        <td>
                            <a href="edit.php?phone=<?php echo $phone; ?>" class="btn btn-primary">View / Edit</a>
                            <a href="delete.php?phone=<?php echo $phone; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="6">No participants found.</td></tr>';
            }

            // Close the database connection
            $conn->close();
            ?>
        </tbody>
    </table>
</div>


    <!-- Bootstrap JS -->
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
