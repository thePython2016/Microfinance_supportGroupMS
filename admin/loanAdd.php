<?php
require 'connectDB.php';
if(isset($_POST["addLoan"]))
{
  

$id=finance_db_escape($connection,$_POST['id']);
$date=finance_db_escape($connection,$_POST['date']);
$member=finance_db_escape($connection,$_POST['member']);
$amount=finance_db_escape($connection,$_POST['amount']);




if($amount<100000)
{
  $interest=$amount*0.2;
}
else
{
  $interest=$amount*0.15;
}
// INSERT TO TABLE
$insertLoan=finance_db_query($connection,"insert into loans
(loanID,date,member,amount,interest)
 values('$id','$date',(select mobileNumber from members where mobileNumber='$member'),'$amount','$interest')");


 $amount=0;
 //  update LOANS table after INSERTION
$updateLoan=finance_db_query($connection,"update loans

SET amount=amount+$amount where member='$member'");





// $count=finance_db_num_rows($farmersQuery);

if($insertLoan)
{
  $_SESSION['addedLoan']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>One record added/p>";
  echo "<script>
  window.location.href='loans.php'
  </script>";
  

  
}
else{

  $_SESSION['addingloanError']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>Error </p>";
}



}
?>