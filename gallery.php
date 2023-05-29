<!DOCTYPE html>
<html>
<head>
    <title>Image Gallery</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .image-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .image-container img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            margin: 10px;
            border-radius: 50%;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .image-container img:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
        }
        .image-gallery {
  column-gap: 10px;
  row-gap: 10px;
  column-count: 4;
}

.image-tile {
  width: 100%;
  height: auto;
  border-radius: 10px;
  overflow: hidden;
}

@media (max-width: 992px) {
  .image-gallery {
    column-count: 3;
  }
}

@media (max-width: 768px) {
  .image-gallery {
    column-count: 2;
  }
}

@media (max-width: 576px) {
  .image-gallery {
    column-count: 1;
  }
}

    </style>
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
          <a class="nav-link" href="cadence85.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Admin Login</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>
<div class="container">
  <h3>Image Gallery</h3>
  <div class="image-gallery">
    <?php
    $imageDir = '.'; // Directory where images are stored
    $allowedExtensions = ['jpg', 'jpeg', 'png']; // Allowed image file extensions

    // Retrieve all image files in the directory
    $images = array_filter(scandir($imageDir), function ($file) use ($allowedExtensions) {
      $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
      return in_array($extension, $allowedExtensions);
    });

    // Display each image as a tile
    foreach ($images as $image) {
      echo '<div class="image-tile">';
      echo '<img src="' . $image . '" class="img-fluid">';
      echo '</div>';
    }
    ?>
  </div>
</div>
</body>
</html>
