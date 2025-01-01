<?php
$host="localhost";
$user="root";
$password="";
$dbname="microfinancedb";

$conn=mysqli_connect($host,$user,$password);
mysqli_select_db($conn,$dbname) or die("Failed to connect". mysqli_connect_error());


?>