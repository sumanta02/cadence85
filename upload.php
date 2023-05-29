<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event = $_POST['eventSelect'];
    $file = $_FILES['file'];
    // Create event folder if it doesn't exist
    $eventFolder = '.';
    /* if (!is_dir($eventFolder)) {
        mkdir($eventFolder, 0777, true);
    } */
    // Process file upload
    $fileName = $file['name'];
    $fileTmpPath = $file['tmp_name'];
    $fileType = $file['type'];
    // Check if the file is a ZIP archive
    if ($fileType === 'application/zip') {
        $zip = new ZipArchive;
        if ($zip->open($fileTmpPath) === true) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                $fileInfo = $zip->statIndex($i);
                $fileExtension = strtolower(pathinfo($fileInfo['name'], PATHINFO_EXTENSION));
                
                // Check if the file is a JPEG, JPG, or PNG
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                    $zip->extractTo($eventFolder, $fileInfo['name']);
                }
            }
            $zip->close();
            echo "Images Uploaded Successfully";
        }
    } else {
        // Check if the file is a JPEG, JPG, or PNG
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {
            $destination = $fileName;
            move_uploaded_file($fileTmpPath, $destination);
            echo "Images Uploaded Successfully";
        }
        echo "Error in uploading images";
    }
}
?>

<DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
    function validateFileType() {
      var inputFile = document.getElementById('file');
      var filePath = inputFile.value;
      var allowedExtensions = /(\.zip|\.jpeg|\.jpg|\.png)$/i;
      if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type! Only ZIP, JPEG, JPG, and PNG files are allowed.');
        inputFile.value = '';
        return false;
      }
    }
  </script>
    <script>
      function showFileName() {
        const fileInput = document.getElementById('file');
        const fileNameLabel = document.getElementById('file-name-label');
        fileNameLabel.textContent = fileInput.files[0].name;
      }
    </script>
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
            <a class="nav-link" href="admin_panel.php">Admin Panel</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="gallery.php">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Log Out</a>
        </li>
      </ul>
    </div>
    <img src="cyclology_logo.png" alt="Logo" width="97" height="97" class="d-inline-block align-text-top">
  </div>
</nav>
    <div class="container">
        <h3>Upload Images</h3>
    <form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="eventSelect">Select Event:</label>
        <select class="form-control" id="eventSelect" name="eventSelect">
          <option value="cadence85/">Cadence 85</option>
          <option value="cadence85-1/">Cadence 85.1</option>
          <option value="cadence85-2/">Cadence 85.2</option>
        </select>
      </div>
      <div class="form-group">
        <label for="file">Select file:</label>
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="file" accept=".zip,.jpg,.jpeg,.png" name="file" onchange="showFileName()" />
          <label class="custom-file-label" id="file-name-label" for="file-upload">Choose file...</label>
        </div>
      </div>
      <button type="submit" class="btn btn-primary">Upload</button>
    </form>
    </div>
    <script>
    function updateFileLabel() {
      var fileInput = document.getElementById('file');
      var fileLabel = document.getElementById('fileLabel');
      var fileName = fileInput.files[0].name;
      fileLabel.innerText = fileName;
    }
  </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>

     <!-- <html>
<head>
<title>PHP File Upload example</title>
</head>
<body>

<form action="" enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file"><br/>
<input type="submit" value="Upload" name="Submit1"> <br/>


</form>
</body>
</html> -->
<!-- <?php
if(isset($_POST['Submit1']))
{ 
$filepath = "/var/www/html/" . $_FILES["file"]["name"];

if(move_uploaded_file($_FILES["file"]["tmp_name"], $filepath)) 
{
echo "<img src=\"".$filepath."\" height=200 width=300 />";
} 
else 
{
echo error_get_last()['message'];
echo sys_get_temp_dir();
}
} 
?> -->