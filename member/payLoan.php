<?php
require 'connectDB.php';
if(isset($_POST["payLoan"]))
{
  

$id=finance_db_escape($connection,$_POST['id']);
$date=finance_db_escape($connection,$_POST['date']);
$member=finance_db_escape($connection,$_POST['member']);
$amount=finance_db_escape($connection,$_POST['amount']);







// INSERT TO TABLE
$payLoan="insert into loanPayments(paymentID,date,member,amount)
 values('$id','$date',(select mobileNumber from members where mobileNumber='$member'),'$amount')";


 if( finance_db_query($connection, $payLoan)==true ){
  //  update LOANS table after payment
  $updateQuery = "UPDATE loans SET amount=amount-$amount  where member='$member'";
  finance_db_query($connection, $updateQuery);
}



if($payLoan)
{
  $_SESSION['addedLoan']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>One record added/p>";
  echo "<script>
  window.location.href='loan-payment.php'
  </script>";
  

  
}
else{

  $_SESSION['addingloanError']="<p style='color:red;font-size:14px;margin-left:200px;font-weight:bold'>Error </p>";
}



}
?>