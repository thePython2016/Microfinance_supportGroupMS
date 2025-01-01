<?php
require 'connectDB.php';
if(isset($_POST["addOfficers"]))
{
  

$phone=mysqli_real_escape_string($connection,$_POST['phone']);
$nin=mysqli_real_escape_string($connection,$_POST['nin']);
$fname=mysqli_real_escape_string($connection,$_POST['fname']);
$mname=mysqli_real_escape_string($connection,$_POST['mname']);
$lname=mysqli_real_escape_string($connection,$_POST['lname']);
$day=mysqli_real_escape_string($connection,$_POST['day']);
$month=mysqli_real_escape_string($connection,$_POST['month']);
$year=mysqli_real_escape_string($connection,$_POST['year']);
$gender=mysqli_real_escape_string($connection,$_POST['gender']);
$address=mysqli_real_escape_string($connection,$_POST['address']);




// INSERT TO TABLE
$insertOfficers=mysqli_query($connection,"insert into officers
(mobileNumber,nin,fname,mname,lname,day,month,year,gender,address)
 values('$phone','$nin','$fname','$mname','$lname','$day','$month','$year','$gender','$address')");



// $count=mysqli_num_rows($farmersQuery);

if($insertOfficers)
{
  $_SESSION['addedOfficer']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>One record added/p>";
  echo "<script>
  window.location.href='members.php'
  </script>";
  

  
}
else{

  $_SESSION['addingofficerError']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>Error </p>";
}



}
?>