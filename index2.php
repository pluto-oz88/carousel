<!-- Load multiple files (based on criteria below) from PC in to directory -->
<!-- on website drive (files in this example) - database not updated -->




<?php
	include_once 'includes/anthea.php';
?>
	


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Multiple file Upload</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>  

</head>
<body>

<h3>Load multiple files (based on criteria below) from PC in to directory</h3>
<h3>on website drive (files in this example) - database not updated</h3>
<br><br>
<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="userfile[]" value="" multiple="">
	<input type="submit" name="submit" value="upload">
</form>

<?php

$phpFileUploadErrors=array(
	0 => 'No errors. File uploaded successfully.',
	1 => 'The uploaded file exceeds the upload_max_filesize specified in php.ini',
	2 => 'The uploaded file exceeds the MAX_FILE_SIZE specified in the HTML form',
	3 => 'The uploaded file was only partially uploaded',
	4 => 'No file uploaded',
	6 => 'Missing a temporary folder.',
	7 => 'Failed to write file to disk.',
	8 => 'A PHP extension prevented the file upload.',
);

if(isset($_FILES['userfile'])) {
	$file_array=reArrayFiles($_FILES['userfile']);
		//pre_r($file_array);
		for ($i=0; $i < count($file_array); $i++) { 
			if ($file_array[$i]['error'] )  {
				?> <div class="alert alert-danger"> 
				<?php echo $file_array[$i]['name'].' - ' .$phpFileUploadErrors[$file_array[$i]['error']];
				?> </div> <?php
		} else {
			$extensions=array('jpg','png','gif','jpeg');
			$file_ext = explode('.', $file_array[$i]['name']);
			$file_ext=end($file_ext);

			if (!in_array($file_ext, $extensions)) {
				?> <div class="alert alert-danger"> 
				<?php echo "{$file_array[$i]['name']} - Invalid file extension!";
				?> </div> <?php
			} else {
				move_uploaded_file($file_array[$i]['tmp_name'], "files/".$file_array[$i]['name']);
				?> <div class="alert alert-success">	

				<?php echo $file_array[$i]['name'].' - '.$phpFileUploadErrors[$file_array[$i]['error']];
				?> </div> <?php
			}
		}
	}
}

function pre_r($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function reArrayFiles( $file_post) {

	$file_ary=array();
	$file_count=count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];

		}
	}
	return $file_ary;
}
?>


</body>
</html>
