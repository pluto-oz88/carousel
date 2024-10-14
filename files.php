<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Dynamic Carousel</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php
//$_FILES
//How to upload files
//1. Upload it to the root
//2. Directly to the database

// enctype="multipart/form-data"
//Specifies how the data should be encoded
?>

<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button type="submit" name="submit">SUBMIT</button>
</form>


</body>
</html>