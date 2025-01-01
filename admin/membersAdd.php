<?php
require 'connectDB.php';
if(isset($_POST["addMembers"]))
{
  

$phone=mysqli_real_escape_string($connection,$_POST['phone']);
$nin=mysqli_real_escape_string($connection,$_POST['nin']);
$email=mysqli_real_escape_string($connection,$_POST['email']);
$fname=mysqli_real_escape_string($connection,$_POST['fname']);
$mname=mysqli_real_escape_string($connection,$_POST['mname']);
$lname=mysqli_real_escape_string($connection,$_POST['lname']);
$day=mysqli_real_escape_string($connection,$_POST['day']);
$month=mysqli_real_escape_string($connection,$_POST['month']);
$year=mysqli_real_escape_string($connection,$_POST['year']);
$gender=mysqli_real_escape_string($connection,$_POST['gender']);
$address=mysqli_real_escape_string($connection,$_POST['address']);




// INSERT TO TABLE
$insertMembers=mysqli_query($connection,"insert into members
(mobileNumber,nin,email,fname,mname,lname,day,month,year,gender,address)
 values('$phone','$nin','$email','$fname','$mname','$lname','$day','$month','$year','$gender','$address')");



// $count=mysqli_num_rows($farmersQuery);

if($insertMembers)
{
  $_SESSION['addedMember']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>One record added/p>";
  echo "<script>
  window.location.href='members.php'
  </script>";
  

  
}
else{

  $_SESSION['addingmemberError']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>Error </p>";
}



}
?>