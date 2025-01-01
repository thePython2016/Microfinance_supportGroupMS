<?php
require 'connectDB.php';
if(isset($_POST["payLoan"]))
{
  

$id=mysqli_real_escape_string($connection,$_POST['id']);
$date=mysqli_real_escape_string($connection,$_POST['date']);
$member=mysqli_real_escape_string($connection,$_POST['member']);
$amount=mysqli_real_escape_string($connection,$_POST['amount']);







// INSERT TO TABLE
$payLoan="insert into loanPayments(paymentID,date,member,amount)
 values('$id','$date',(select mobileNumber from members where mobileNumber='$member'),'$amount')";


 if( mysqli_query($connection, $payLoan)==true ){
  //  update LOANS table after payment
  $updateQuery = "UPDATE loans SET amount=amount-$amount  where member='$member'";
  mysqli_query($connection, $updateQuery);
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