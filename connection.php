<?php

$server = 'localhost';
$user = 'aldec2';
$user = 'grahamd';
$pass = 'Alex4783?';
$pass = 'Hakuba4791';
$dbase = 'aldec2';


$con = new mysqli($server, $user, $pass, $dbase);
if ($con->connect_error) {
    die("Error connecting to Dbase: " . $con->connect_error);
}
