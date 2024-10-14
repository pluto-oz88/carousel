<?php
	include_once 'includes/anthea.php';
?>
	


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>  
  <style>
  /* Make the image fully responsive */
  .carousel-inner img {
    width: 40%;
    height: 40%;
  }
  </style>
</head>
<body>

<h1>DEMO CAROUSEL</h1>

<div id="demo" class="carousel slide" data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li data-target="#demo" data-slide-to="0" class="active"></li>
    <li data-target="#demo" data-slide-to="1"></li>
    <li data-target="#demo" data-slide-to="2"></li>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
  
  <?php
  		$sql="SELECT * FROM renopics;";
		$result=mysqli_query($conn, $sql);
		$resultCheck=mysqli_num_rows($result);
?>
  
  
	<?php 
	    $hasAddedActive = false;
	    //while ($row = mysql_fetch_assoc($result)) {   
	    
	    if ($resultCheck) {
		while ($row = mysqli_fetch_array($result)) {
			echo "<img src=" . $row['beforeA'] . "<br>";	    
			$id =($row['Aindex']);                      
	    	$image =($row['beforeA']);

		}
	}
	
	
	
	
	
	
	
	
	
	    
	    
	    
	    
	    
	    //while ($row = mysql_fetch_array($result)) {      
	    $id =($row['Aindex']);                      
	    $image =($row['beforeA']);
	?>
	
	<?php 
	    $divClass = 'carousel-item bnw-filter';
	    $divClass .= $hasAddedActive ? '' : ' active';
	    $hasAddedActive = true;
	    echo('<div class="'.$divClass.'">'); 
	?>
	    <?php 
	        echo '<a href="artykul.php?id='.$id.'">'; 
	        echo '<img src="$image" class="img-fluid">';
	       	//echo '<img src="images/'.$image.'" class="img-fluid">';
	        echo '</a>'; 
	    ?>
	<?php echo('</div>'); ?>    
	
	<? } ?>  
	
	</div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>


<?php
	$sql="SELECT * FROM renopics;";
	$result=mysqli_query($conn, $sql);
	$resultCheck=mysqli_num_rows($result);
	
	
	if ($resultCheck) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo $row['name'] . "<br>";
		}
	}

?>


</body>
</html>
