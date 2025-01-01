<?php
$host="localhost";
$user="root";
$password="";
$dbname="microfinancedb";

$connection=mysqli_connect($host,$user,$password);
mysqli_select_db($connection,$dbname) or die("Failed to connect". mysqli_connect_error());


?>