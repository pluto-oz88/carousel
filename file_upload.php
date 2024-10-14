<?php
session_start();

include 'connection.php';


// Check if form was submitted 
if (isset($_POST['submit'])) {

	//echo "Made it to here <br>";
	// Configure upload directory and allowed file types 
	$upload_dir = 'photos' . DIRECTORY_SEPARATOR;
	$allowed_types = array('jpg', 'png', 'jpeg', 'gif');
	$picCount = 0;
	$portraitHeight = 2000;
	$maxWidth = 1500;
	$landscapeHeight = 1125;


	// Define maxsize for files i.e 20MB 
	$maxsize = 20 * 1024 * 1024;

	echo 'Made it ti here -' . 'filename - ' . $filename;


	// Checks if user sent an empty form  
	if (!empty(array_filter($_FILES['files']['name']))) {

		// Loop through each file in files[] array 
		foreach ($_FILES['files']['tmp_name'] as $key => $value) {

			$file_tmpname = $_FILES['files']['tmp_name'][$key];
			$file_name = $_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

			//echo $file_size . '<br>';
			echo 'GD $filename - ' . $file_name . '<br>';

			// Set upload file path 
			$filepath = $upload_dir . $file_name;
			echo 'GD $filepath - ' . $filepath . '<br>';


			// Check file type is allowed or not 
			if (in_array(strtolower($file_ext), $allowed_types)) {

				// Verify file size - 20MB max  
				if ($file_size > $maxsize)
					echo "Error: File size is larger than the allowed limit.";

				// If file with name already exist then append time in 
				// front of name of the file to avoid overwriting of file 
				if (file_exists($filepath)) {
					// $filepath = $upload_dir.time().$file_name; 

					if (move_uploaded_file($file_tmpname, $filepath)) {
						echo "{$file_name} successfully uploaded <br />";

						list($width, $height, $type, $attr) = getimagesize($upload_dir . $file_name);

						//echo "Image width " . $width;
						//echo "Image height " . $height;
						//echo "Image type " . $type;
						echo "Attribute " . $attr;

						if ($width > $height) {
							echo "Landscape<br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $landscapeHeight, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						} elseif ($height > $width) {
							echo "Portrait<br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $portraitHeight, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						} else {

							echo "Square <br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $maxWidth, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						}



						$mysqli->query("INSERT INTO photographs (filename, display) VALUES('$file_name', 1)") or die($mysqli->error);

						echo "Image {$file_name} resized and overwritten<br>";

						$picCount = $picCount + 1;
					} else {
						echo "Error uploading {$file_name} <br />";
					}
				} else {

					if (move_uploaded_file($file_tmpname, $filepath)) {
						echo "{$file_name} successfully uploaded <br />";

						list($width, $height, $type, $attr) = getimagesize($upload_dir . $file_name);

						//echo "Image width " . $width;
						//echo "Image height " . $height;
						//echo "Image type " . $type;
						echo "Attribute " . $attr;

						if ($width > $height) {
							echo "Landscape<br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $landscapeHeight, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						} elseif ($height > $width) {
							echo "Portrait<br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $portraitHeight, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						} else {

							echo "Square <br>";
							$resize = new ResizeImage($upload_dir . $file_name);
							$resize->resizeTo($maxWidth, $maxWidth, 'exact');
							$resize->saveImage($upload_dir . $file_name);
						}

						$mysqli->query("INSERT INTO photographs (filename, display) VALUES('$file_name', 0)") or die($mysqli->error);
						echo "Image {$file_name} resized and saved<br>";
						$picCount = $picCount + 1;
					} else {
						echo "Error uploading {$file_name} <br />";
					}
				}
			} else {

				// If file extention not valid 
				echo "Error uploading {$file_name} ";
				echo "({$file_ext} file type is not allowed)<br / >";
			}
		}
	} else {

		// If no files selected 
		echo "No files selected.";
	}

	echo "<br>Resizing and upload of {$picCount} photos completed";

	$_SESSION['message'] = "Resizing and upload of {$picCount} new photos completed";
	$_SESSION['msg_type'] = "success";

	//header("location: index.php");
}

?> 


<?php
/**
 * Resize image class will allow you to resize an image
 *
 * Can resize to exact size
 * Max width size while keep aspect ratio
 * Max height size while keep aspect ratio
 * Automatic while keep aspect ratio
 */
class ResizeImage
{
	private $ext;
	private $image;
	private $newImage;
	private $origWidth;
	private $origHeight;
	private $resizeWidth;
	private $resizeHeight;
	/**
	 * Class constructor requires to send through the image filename
	 *
	 * @param string $filename - Filename of the image you want to resize
	 */
	public function __construct($filename)
	{
		if (file_exists($filename)) {
			$this->setImage($filename);
		} else {
			throw new Exception('Image ' . $filename . ' can not be found, try another image.');
		}
	}
	/**
	 * Set the image variable by using image create
	 *
	 * @param string $filename - The image filename
	 */
	private function setImage($filename)
	{
		$size = getimagesize($filename);
		$this->ext = $size['mime'];
		switch ($this->ext) {
				// Image is a JPG
			case 'image/jpg':
			case 'image/jpeg':
				// create a jpeg extension
				$this->image = imagecreatefromjpeg($filename);
				break;
				// Image is a GIF
			case 'image/gif':
				$this->image = @imagecreatefromgif($filename);
				break;
				// Image is a PNG
			case 'image/png':
				$this->image = @imagecreatefrompng($filename);
				break;
				// Mime type not found
			default:
				throw new Exception("File is not an image, please use another file type.", 1);
		}
		$this->origWidth = imagesx($this->image);
		$this->origHeight = imagesy($this->image);
	}
	/**
	 * Save the image as the image type the original image was
	 *
	 * @param  String[type] $savePath     - The path to store the new image
	 * @param  string $imageQuality 	  - The qulaity level of image to create
	 *
	 * @return Saves the image
	 */
	public function saveImage($savePath, $imageQuality = "100", $download = false)
	{
		switch ($this->ext) {
			case 'image/jpg':
			case 'image/jpeg':
				// Check PHP supports this file type
				if (imagetypes() & IMG_JPG) {
					imagejpeg($this->newImage, $savePath, $imageQuality);
				}
				break;
			case 'image/gif':
				// Check PHP supports this file type
				if (imagetypes() & IMG_GIF) {
					imagegif($this->newImage, $savePath);
				}
				break;
			case 'image/png':
				$invertScaleQuality = 9 - round(($imageQuality / 100) * 9);
				// Check PHP supports this file type
				if (imagetypes() & IMG_PNG) {
					imagepng($this->newImage, $savePath, $invertScaleQuality);
				}
				break;
		}
		if ($download) {
			header('Content-Description: File Transfer');
			header("Content-type: application/octet-stream");
			header("Content-disposition: attachment; filename= " . $savePath . "");
			readfile($savePath);
		}
		imagedestroy($this->newImage);
	}
	/**
	 * Resize the image to these set dimensions
	 *
	 * @param  int $width        	- Max width of the image
	 * @param  int $height       	- Max height of the image
	 * @param  string $resizeOption - Scale option for the image
	 *
	 * @return Save new image
	 */
	public function resizeTo($width, $height, $resizeOption = 'default')
	{
		switch (strtolower($resizeOption)) {
			case 'exact':
				$this->resizeWidth = $width;
				$this->resizeHeight = $height;
				break;
			case 'maxwidth':
				$this->resizeWidth  = $width;
				$this->resizeHeight = $this->resizeHeightByWidth($width);
				break;
			case 'maxheight':
				$this->resizeWidth  = $this->resizeWidthByHeight($height);
				$this->resizeHeight = $height;
				break;
			default:
				if ($this->origWidth > $width || $this->origHeight > $height) {
					if ($this->origWidth > $this->origHeight) {
						$this->resizeHeight = $this->resizeHeightByWidth($width);
						$this->resizeWidth  = $width;
					} else if ($this->origWidth < $this->origHeight) {
						$this->resizeWidth  = $this->resizeWidthByHeight($height);
						$this->resizeHeight = $height;
					}
				} else {
					$this->resizeWidth = $width;
					$this->resizeHeight = $height;
				}
				break;
		}
		$this->newImage = imagecreatetruecolor($this->resizeWidth, $this->resizeHeight);
		imagecopyresampled($this->newImage, $this->image, 0, 0, 0, 0, $this->resizeWidth, $this->resizeHeight, $this->origWidth, $this->origHeight);
	}
	/**
	 * Get the resized height from the width keeping the aspect ratio
	 *
	 * @param  int $width - Max image width
	 *
	 * @return Height keeping aspect ratio
	 */
	private function resizeHeightByWidth($width)
	{
		return floor(($this->origHeight / $this->origWidth) * $width);
	}
	/**
	 * Get the resized width from the height keeping the aspect ratio
	 *
	 * @param  int $height - Max image height
	 *
	 * @return Width keeping aspect ratio
	 */
	private function resizeWidthByHeight($height)
	{
		return floor(($this->origWidth / $this->origHeight) * $height);
	}
}
?>