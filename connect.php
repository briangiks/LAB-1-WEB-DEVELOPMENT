<?php
//connect to db
$server = 'localhost';
$user = 'root';
$password = '';
$database = 'lab';
//establish connection
$conn = mysqli_connect($server, $user, $password, $database);
if (!$conn) {
    die(mysqli_connect_error());
}
