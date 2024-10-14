<?php


$server = 'localhost';
$user = 'aldec2';
$user = 'grahamd';
$pass = 'Alex4783?';
$pass = 'Hakuba4791';
$dbase = 'aldec2';

$conn = mysqli_connect($server, $user, $pass, $dbase);

// Check connection
if (!$conn) {
	die("Connection failed: " . mysqli_connect_error());
}

//$result=$conn->query("SELECT * FROM renopics WHERE showpic"); 
$result = $conn->query("SELECT * FROM photograph WHERE display = 1");

print_r($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Aldevanddec.com</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/carousel.chttps://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/ss">

</head>

<body>
	<h3>This will bulk copy photos from your drive </h3>
	<h3>to the website and update the database.</h3>
	<br><br>
	<!-- multipart/form-data ensures that form 
    data is going to be encoded as MIME data -->
	<form action="#" method="POST" enctype="multipart/form-data">

		Select files to upload:
		<input type="file" name="file[]" multiple>
		<input type="submit" name="submit" value="Upload Image" class="btn btn-primary">
	</form>

</body>

</html>