
<?php
require "connectDB.php";
function simplePhoneFromat($phones){
    $phone_formated = [];
    foreach($phones ?: [] as $ph){
        $phone_formated[]= "255".substr($ph,1);
    }
    //implode to convert to array separated by comma, always for above to work make sure the phone numbers in your db start with 0CCCCCCCCCC
     return implode(',',$phone_formated);
}
if(isset($_POST['send-sms']))
{
$sender=$_POST['sender'];
$phone=$_POST['phone'];
$subject=$_POST['subject'];
$message=$_POST['message'];
$phone = simplePhoneFromat($phone); //removes zero from phone, this will work if your send to only one person, for multiple you must pass through a loop

//this is shell curl use php curl, wait...
$url = "https://portal.zepsonsms.co.tz/api/v3/sms/send";
$token = "22|MefsVNsF0t9F47Mg9LKwMlClYjfczhbiadUrBUOe888d453b";

$data = [
    "recipient" =>$phone,// PHONE NUMBER MUST START WITH 255, I FYOU WANT TO SEND TO MULTIPLE PEOPLE YOU SEPARATE NUMBER BY COMMA. 255752771650,255654485755 ...
    "sender_id" => $sender, // you can uyse active sender id, for now its ZEPSONSMS, you can apply for yours at 50KTZS
    "type" => "plain",
    "message" => $message,
    // "schedule_time" => "2021-12-20 07:00" //REQUIRED IF YOU WANT TO SEND MESSAGE LETER, YOU SET THE TIME YOU WANT
];

$headers = [
    "Authorization: Bearer $token",
    "Content-Type: application/json",
    "Accept: application/json"
];

// Initialize cURL session
$ch = curl_init($url);


// Set cURL options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute request and get response
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // echo 'Response: ' . $response;
    date_default_timezone_set('Africa/Nairobi');
    $date=date('Y-m-d H:i:s');
    $id=$_POST['id'];
    
    $sender=$_POST['sender'];
    $phone=$_POST['phone'];
    $phone2=json_encode($phone);
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    $insertSentmessage=finance_db_query($connection,"insert into sent_sms(id,date,sender_name,receiver_name,subject,message)
            
    values('$id','$date','$sender','$phone2','$subject','$message')");
    $_SESSION['message']="<p style='color:grey;font-size:14px;margin-left:200px;font-weight:bold'>Your Message has been sent</p>";
    echo "<script>
   alert('Your Message has been sent!!')
   window.location.href='new-sms.php';
    </script>";
}

// Close cURL session
// curl_close($ch);

}

 