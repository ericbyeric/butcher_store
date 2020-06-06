<?php
    
$servername = "localhost";
$dBUsername = 'root';
$dBPassword = 'root';
$dBName = "butcherStore";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if(!$conn) {
    // if connection not created
    // kill the connection
    die("Connection failed:".mysqli_connect_error());
}