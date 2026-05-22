<?php
require 'connectDB.php';
if(isset($_POST["addShares"]))
{
  

$id=finance_db_escape($connection,$_POST['id']);
$date=finance_db_escape($connection,$_POST['date']);
$member=finance_db_escape($connection,$_POST['member']);
$amount=finance_db_escape($connection,$_POST['amount']);





// INSERT TO TABLE
$insertShares=finance_db_query($connection,"insert into shares
(shareID,date,member,amount)
 values('$id','$date',(select mobileNumber from members where mobileNumber='$member'),'$amount')");

//  update shareTable table after INSERTION
$amount=0;
$updateLoan=finance_db_query($connection,"update shares

SET amount=amount-$amount where member='$member'");



// $count=finance_db_num_rows($farmersQuery);

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