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
//echo "Connected successfully";
