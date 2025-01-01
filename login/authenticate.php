<?php
include ("connection.php");


// Collect data 
if(isset($_POST['submit']))
{
  $username=$_POST['username'];
  $pass=$_POST['password'];
  //Secure
$username=mysqli_real_escape_string($conn,$username);
$pass=mysqli_real_escape_string($conn,$pass);

  $selectuser="select username,password,user_category from profile where username='$username' AND password='$pass'";
  $user=mysqli_query($conn,$selectuser);
  $usercat=mysqli_fetch_array($user);
  $returncat=$usercat['user_category'];
  
  echo $returncat;
  if($returncat==1)
  {
    session_start();
    $_SESSION['username']=$username;
   header("Location:../system/adminPanel.php");
   
  }
  else{
    header("Location:index.php");
  }
}

?>