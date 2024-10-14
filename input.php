<?php
if (isset($_POST['submit'])) {

    $totalfiles = count($_FILES['file']['name']);
    echo 'total files - ' . $totalfiles;
    echo '<br>';
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <!-- The data encoding type, enctype, MUST be specified as below -->
    <form enctype="multipart/form-data" action="" method="POST">
        <!-- MAX_FILE_SIZE must precede the file input field -->
        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <!-- Name of input element determines name in $_FILES array -->
        Send this file: <input name="userfile" type="file" />
        <input type="submit" name="submit" value="Send File" />
    </form>



</body>

</html>