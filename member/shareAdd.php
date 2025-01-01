<?php
require 'connectDB.php';
if(isset($_POST["addShares"]))
{
  

$id=mysqli_real_escape_string($connection,$_POST['id']);
$date=mysqli_real_escape_string($connection,$_POST['date']);
$member=mysqli_real_escape_string($connection,$_POST['member']);
$amount=mysqli_real_escape_string($connection,$_POST['amount']);





// INSERT TO TABLE
$insertShares=mysqli_query($connection,"insert into shares
(shareID,date,member,amount)
 values('$id','$date',(select mobileNumber from members where mobileNumber='$member'),'$amount')");

//  update shareTable table after INSERTION
$amount=0;
$updateLoan=mysqli_query($connection,"update shares

SET amount=amount-$amount where member='$member'");



// $count=mysqli_num_rows($farmersQuery);

if($insertShares)
{
  $_SESSION['addedMember']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>One record added/p>";
  echo "<script>
  window.location.href='shares.php'
  </script>";
  

  
}
else{

  $_SESSION['addingmemberError']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>Error </p>";
}



}
?>