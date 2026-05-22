<?php
require 'connectDB.php';
if(isset($_POST["addMembers"]))
{
  

$phone=finance_db_escape($connection,$_POST['phone']);
$nin=finance_db_escape($connection,$_POST['nin']);
$email=finance_db_escape($connection,$_POST['email']);
$fname=finance_db_escape($connection,$_POST['fname']);
$mname=finance_db_escape($connection,$_POST['mname']);
$lname=finance_db_escape($connection,$_POST['lname']);
$day=finance_db_escape($connection,$_POST['day']);
$month=finance_db_escape($connection,$_POST['month']);
$year=finance_db_escape($connection,$_POST['year']);
$gender=finance_db_escape($connection,$_POST['gender']);
$address=finance_db_escape($connection,$_POST['address']);




// INSERT TO TABLE
$insertMembers=finance_db_query($connection,"insert into members
(mobileNumber,nin,email,fname,mname,lname,day,month,year,gender,address)
 values('$phone','$nin','$email','$fname','$mname','$lname','$day','$month','$year','$gender','$address')");



// $count=finance_db_num_rows($farmersQuery);

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