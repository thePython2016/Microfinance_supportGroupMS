<?php
require "admin/connectDB.php";


// Collect data 
if(isset($_POST['submit']))
{
  $username=$_POST['username'];
  $pass=$_POST['password'];
  //Secure
$username=finance_db_escape($connection,$username);
$pass=finance_db_escape($connection,$pass);

  $selectuser="select username,password,user_category from profile where username='$username' AND password='$pass'";
  $user=finance_db_query($connection,$selectuser);
  $usercat=finance_db_fetch_array($user);
  $returncat=$usercat['user_category'];
  
  echo $returncat;
  if($returncat==1)
  {
    session_start();
    $_SESSION['username']=$username;
   header("Location:admin/admin.php");
   
  }
  else if($returncat==2)
  {
    session_start();
    $_SESSION['username']=$username;
   header("Location:member/macro-member.php");
   
  }
  else if($returncat==3)
  {
    session_start();
    $_SESSION['username']=$username;
   header("Location:financial-officer/financial-officer.php");
   
  }
  else{
    header("Location:index.php");
  }
}

?>