<?php
use PHPMAILER\PHPMAILER\PHPMAILER;
use PHPMAILER\PHPMAILER\exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'connectDB.php';
$sql = "select * from members where  email='$_POST[email]' OR '$_POST[email]'=''"; 
// $sql = "select * from members where   email = CASE WHEN $_POST[email] = 0 THEN email ELSE $_POST[email] END"; 

  
// Query for the making the connection. 
$res = mysqli_query($connection, $sql); 
if(isset($_POST['send']))
{
    $mail=new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host='smtp.gmail.com';
    $mail->SMTPAuth=true;
    $mail->Username='lucysamwel765@gmail.com';
    $mail->Password='vxfz inxn cjfa nuhe';
    $mail->SMTPSecure='ssl';
    $mail->Port=465;
    $mail->setFrom('lucysamwel765@gmail.com');

  
if(mysqli_num_rows($res) > 0) { 
    while($x = mysqli_fetch_assoc($res)) { 
        $mail->addAddress($x['email']); 
 
    } 
  

    $mail->iSHTML(true);
    $mail->Subject=$_POST['subject'];
    $mail->Body=$_POST['message'];

    if(!$mail->send()) {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
       echo 

       "<script>
       alert('Message has been sent Successfully');
       window.location.href='compose-message.php';
       </script>";

    }
}
}
?>


