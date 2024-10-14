<?php
	include_once 'includes/anthea.php';
	$msg='';
	
	//if(isset($POST['upload'])){
		if($_POST && isset($_POST['upload'])) {

		$image=$_FILES['image']['name'];
		$path='images/' .$image;

		$sql=$conn->query("INSERT INTO slider (image_path) VALUES ('$path')");

		if($sql) {
			move_uploaded_file($_FILES['image']['tmp_name'], $path);
			$msg='Image Uploaded Successfully!';
		} else {
			$msg='Image Upload Failed!';
		}
	}
	$result=$conn->query("SELECT image_path FROM slider WHERE Showpic");

?>
	


<!DOCTYPE html>
<html lang="en">
<head>
<title>Dynamic BS4 Carousel</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>  
<link rel="stylesheet" href="css/carousel.css">

</head>
<body>

<div class="container">

	<h2 class="text-center bg-dark text-light pb-2">DYNAMIC BOOTSTRAP 4 CAROUSEL</h2>

	<div id="demo" class="carousel slide" data-ride="carousel">

		<!-- Indicators -->
		<ul class="carousel-indicators">
		<?php
			$i =0;
			foreach ($result as $row) {
				$actives='';
				if($i==0) {
					$actives='active';
				}
		?>
		<li data-target="#demo" data-slide-to="<?= $i; ?>" class="<?= $actives; ?>"></li>
		<?php $i++; 
		} ?>
		</ul>
		<!-- Indicators End -->

		<!-- The slideshow -->
		<div class="carousel-inner">
			<?php
				$i =0;
				foreach ($result as $row) {
					$actives='';
					if($i==0) {
						$actives='active';
					}
			?>
			
			<div class="carousel-item <?= $actives; ?>">
				<div class="row"> 
					<div class="col-sm-6 bg-success p-0">
						<img class="beforepic" src="<?=$row['image_path'] ?>">
						<p class="pictextl">This is the most crap pic ever</p>
                    </div>
                    <div class="col-sm-6 bg-success p-0">
						<img class="afterpic" src="<?=$row['image_path'] ?>">
						<p class="pictextr">This is the bestest pic ever</p>
					</div>
				</div>

				<div class="row">
                    <div class="col-sm-12">
						<p class="bothtext">This text describes the whole comparison 
                        between good and evil and can be seen as the Anthea Lavender method. This text describes the whole comparison 
                        between good and evil and can be seen as the Anthea Lavender method</p>
					</div>
                </div>




			</div>
			<?php $i++; } ?>
		</div>

		<!-- Left and right controls -->
		<a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		</a>
		<a class="carousel-control-next" href="#demo" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		</a>
	</div>

	<br><br>

	<div class="row justify-content-center">
		<div class="col-sm-4 bg-dark rounded px-4">
			<h4 class="text-center text-light p-1">Select Image to Upload</h4>
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="file" name="image" class="form-control p-1" required>
				</div>
				<div class="form-group">
					<input type="submit" name="upload" class="btn btn-warning btn-block" value="Upload Image">
				</div>
				<div class="form-group">
					<h5 class="text-center text-light"><?=$msg; ?></h5>
				</div>
			</form>
		</div>
	</div>

</div>

</body>
</html>
