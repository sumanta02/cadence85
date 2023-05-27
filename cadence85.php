<?php
// Function to sanitize form inputs
function sanitizeInput($input)
{
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize form inputs
    $name = sanitizeInput($_POST["name"]);
    $age = sanitizeInput($_POST["age"]);
    $gender = sanitizeInput($_POST["gender"]);
    $address = sanitizeInput($_POST["address"]);
    $city = sanitizeInput($_POST["city"]);
    $pincode = sanitizeInput($_POST["zip"]);
    $club = sanitizeInput($_POST["club"]);
    $phone = sanitizeInput($_POST["mobile"]);
    $email = sanitizeInput($_POST["email"]);
    $bloodGroup = sanitizeInput($_POST["bloodgroup"]);
    $category = sanitizeInput($_POST["category"]);
    $bikeType = sanitizeInput($_POST["typeofbike"]);
    $emergencyContactName = sanitizeInput($_POST["econtactname"]);
    $emergencyContactNumber = sanitizeInput($_POST["econtactnumber"]);

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

    // Check if the participant with the same phone number already exists
    $checkQuery = "SELECT phone FROM participants WHERE phone = $phone";
    $result = $conn->query($checkQuery);

    if ($result->num_rows == 0) {
        // Insert the participant data into the table
        $insertQuery = "INSERT INTO participants (name, age, gender, address, city, pincode, club, phone, email, blood_group, category, bike_type, emergency_contact_name, emergency_contact_number)
            VALUES ('$name', $age, '$gender', '$address', '$city', $pincode, '$club', $phone, '$email', '$bloodGroup', '$category', '$bikeType', '$emergencyContactName', $emergencyContactNumber)";

        if ($conn->query($insertQuery) === true) {
            $message = "Participant data inserted successfully!";
            $alertClass = "alert-success";
        } else {
            $message = "Error inserting data: " . $conn->error;
            $alertClass = "alert-danger";
        }
    } else {
        $message = "Participant with the same phone number already exists!";
        $alertClass = "alert-warning";
    }

    // Close the database connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Cadence 85.2</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    .banner {
  background-image: url('banner-image-cadence85.jpg');
  background-size: cover;
  background-position: center;
  height: 810px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.event-name {
  font-size: 48px;
  color: #fff;
}

.event-date {
  font-size: 24px;
  color: #fff;
  margin-top: 10px;
}

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
          <a class="nav-link active" href="cadence85.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Admin Login</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>

<section class="banner p-4">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6">
        <h1 class="event-name">Drag Race</h1>
        <p class="event-date">Date: 28th May, 2023</p>
      </div>
    </div>
  </div>
</section>

<section class="about-section p-4">
  <div class="container p-20">
    <div class="row">
      <div class="col-lg-8 offset-lg-2">
        <div class="about-section-main">
          <p class="about-section-description">Join us for an exhilarating and unheard event in the city - the first-ever Drag Race! Get ready to showcase your sprinting strength in an adrenaline-fueled, one-on-one format that will push your limits and leave you craving for more.</p>

          <div class="event-details">
            <h2>Event Details:</h2>
            <p><b>Date:</b> 28th May</p>
            <p><b>Venue:</b> Newtown</p>
            <p><b>Registration Fees:</b> Rs. 100/-</p>
          </div>

          <div class="event-categories">
            <h2>Categories:</h2>
            <div class="category">
              <h4>Men Road</h4>
              <p>For those riding sleek and fast road bikes, this category is designed to test your speed and agility on empty trafficless city streets. Unleash your power and leave your competitors in the dust as you race towards victory.</p>
            </div>
            <div class="category">
              <h4>Men MTB</h4>
              <p>Are you an avid mountain biker? This category is tailored for riders with sturdy mountain bikes. Get ready to showcase your mountain biking prowess in a unique urban setting that will put your abilities to the test.</p>
            </div>
            <div class="category">
              <h4>Women Open</h4>
              <p>Ladies, it's your time to shine! Whether you're a road cyclist or an MTB enthusiast, this category welcomes women of all cycling backgrounds. Join us and let your passion for cycling take center stage in an empowering display of athleticism.</p>
            </div>
          </div>

          <p class="about-section-note"><b>Note:</b> Safety precautions and guidelines will be strictly followed to ensure a secure and enjoyable racing experience for all participants.</p>

          <p class="about-section-come-show">Don't miss this incredible opportunity to be a part of the city's first-ever Drag Race. Get ready to feel the adrenaline rush, experience fierce competition, and create unforgettable cycling memories. Mark your calendars for 28th May and register today to secure your spot in this thrilling event. Come and show the city what you're made of!</p>
        </div>
      </div>
    </div>
  </div>
</section>


    <div class="container p-4">
    <h2 class="section-title text-center">Add Participant</h2>
    <div class="form-section">
        <form action="" class="row g-3" method="post">
            <div class="col-md-4">
            <label for="name" class="form-label">Name*</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name" aria-label="Name" required>
            </div>
            <div class="col-md-4">
            <label for="age" class="form-label">Age*</label>
            <select id="inputname" name="age" class="form-select form-control" required>
            <option selected>Choose...</option>
            <?php for ($i = 14; $i <= 75; $i++) {
                echo '<option value="' . $i . '">' . $i . "</option>";
            } ?>
            </select>
            </div>

            <div class="col-md-4">
            <label for="gender" class="form-label">Gender*:</label>
            <select id="inputname" name="gender" class="form-select form-control" required>
                <option selected>Choose...</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Others</option>
            </select>
            </div>

            <div class="col-12">
            <label for="address" class="form-label">Address*</label>
            <input type="text" class="form-control" name="address" id="inputAddress" placeholder="Enter Address" required>
            </div>



            <div class="col-md-6">
            <label for="inputAddress" class="form-label">City/District*</label>
            <input type="text" class="form-control" name="city" id="inputAddress" placeholder="Enter City" required>
            </div>

            <div class="col-md-6">
            <label for="inputZip" class="form-label">Pincode*</label>
            <input type="number" class="form-control" pattern="[0-9]" name="zip" id="inputZip" placeholder="Enter Pincode" required>
            </div>

            <div class="col-md-4">
            <label for="club" class="form-label">Club / team</label>
            <input type="text" class="form-control" name="club" id="inputname" placeholder="Enter Club">
            </div>

            <div class="col-md-4">
            <label for="mobile" class="form-label">Phone*</label>
            <input type="number" class="form-control" name="mobile" id="mobile" placeholder="Enter Phone No." required>
            </div>

            <div class="col-md-4">
            <label for="email" class="form-label">Email*</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" required>
            <span id="email_result"></span>
            </div>

            <div class="col-md-6">
            <label for="bloodgroup" class="form-label">Blood group</label>
            <select id="inputname" name="bloodgroup" class="form-select form-control">
                <option selected>Choose...</option>
                <option value="A+">A+</option>
                <option value="O+">O+</option>
                <option value="B+">B+</option>
                <option value="AB+">AB+</option>
                <option value="A-">A-</option>
                <option value="O-">O-</option>
                <option value="B-">B-</option>
                <option value="AB-">AB-</option>
            </select>
            </div>

            <div class="col-md-3">
                    <label for="category" class="form-label">Category*:</label>
                    <select id="inputname" name="category" class="form-select form-control" required>
                        <option selected>Choose...</option>
                        <option value="U-18">U-18</option>
                        <option value="Elite (18-35)">Elite (18-35)</option>
                        <option value="Masters (35+)">Masters (35+)</option>
                    </select>
                    </div>

            <div class="col-md-6">
            <label for="typeofbike" class="form-label">Type of Bike*:</label>
            <select id="inputname" name="typeofbike" class="form-select form-control" required>
                <option selected>Choose...</option>
                <option value="Road / Hybrid">Road / Hybrid</option>
                <option value="MTB">MTB</option>

            </select>
            </div>

            <div class="col-md-6">
            <label for="econtactname" class="form-label">Emergency contact name*</label>
            <input type="text" class="form-control" name="econtactname" placeholder="Enter  Emergency Contact Name" aria-label="Emergency contact name" required>
            </div>

            <div class="col-md-6">
            <label for="econtactnumber" class="form-label">Emergency contact number*</label>
            <input type="number" class="form-control" pattern="[0-9]" name="econtactnumber" id="number" placeholder="Enter Contact Number" required>
            <span id="contact_result"></span>
            </div>

            <div class="col-md-6">
            <div class="home-rules-check-box">
                <input type="checkbox" id="is_blogfeatured" name="rules-and-regulations" value="We have read and Agee to the Rules & regulations of the Time Trial" required>
                <label for="rulesAndRegulations" class="form-label"><a href="https://cadence85.cyclologyindia.com/rules-and-regulations" target="blank"> We have read and agreed to the <span style="font-weight: 600;color: #e31719;font-size: 16px;">Rules & regulations</span> of the Drag Race</a></label>
            </div>
            </div>
            <div class="col-md-6">
            <div class="home-rules-check-box">
                <input type="checkbox" id="is_blogfeatured" name="terms_conditions" value="The organisers will not be responsible for any mishaps" required>
                <label for="termsAndConditions" class="form-label">The organisers will not be responsible for any mishaps</label>
            </div>
            </div>
            <div class="col-12">
            <button type="submit" id="submit" class="btn btn-success">Submit</button>
            </div>
        </form>
        </div>
        </div>

</div>

        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "Passwd@123";
        $dbname = "cyclology";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch registered participants
        $sql = "SELECT * FROM participants";
        $result = $conn->query($sql);
        ?>

<section class="participants-section p-4">
  <div class="container">
    <h2 class="section-title text-center">Participants</h2>
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Team</th>
          <th>Type of Bike</th>
          <th>Payment Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0) {
            $count = 1;
            while ($row = $result->fetch_assoc()) {
                $team = $row["club"] ? $row["club"] : "-";
                echo "<tr>";
                echo "<td>" . $count . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $team . "</td>";
                echo "<td>" . $row["bike_type"] . "</td>";
                echo "<td>" . $row["payment"] . "</td>";
                echo "</tr>";
                $count++;
            }
        } else {
            echo "<tr><td colspan='5'>No participants registered yet.</td></tr>";
        } ?>
      </tbody>
    </table>
  </div>
</section>

<?php // Close the database connection
$conn->close(); ?>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
    </html>
