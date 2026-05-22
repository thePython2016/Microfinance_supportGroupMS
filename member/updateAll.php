<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
require 'connectDB.php';
if(isset($_POST['updateMembers']))
{
    $phone=$_POST['phone'];
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $mname=$_POST['mname'];


    $updateMembers =finance_db_query($connection,"update members
    set

   fname='$fname',
    mname='$mname',
   lname='$lname'


where mobileNumber='$phone'
    ");

    if($updateMembers)
    {

        echo  "
        <script>
        window.location.href='members-list.php';
        </script>
        ";
    }

    else{
        echo "
        <script>
        alert('Error Occured');
        window.location.href='members-list.php';
        </script>
        ";
    }
}

// Update SHARES

if(isset($_POST['updateShares']))
{
    $id=$_POST['id'];
    $date=$_POST['date'];
    $amount=$_POST['amount'];



    $updateShares =finance_db_query($connection,"update shares
    set

   date='$date',
    amount='$amount'



where shareID='$id'
    ");

    if($updateShares)
    {

        echo  "
        <script>
        window.location.href='shares-list.php';
        </script>
        ";
    }

    else{
        echo "
        <script>
        alert('Error Occured');
        window.location.href='shares-list.php';
        </script>
        ";
    }
}

// Update officers
if(isset($_POST['updateOfficers']))
{
    $mobile=$_POST['mobile'];

    $firstname=$_POST['firstname'];
    $lastname=$_POST['lastname'];
    $middlename=$_POST['middlename'];
    $address=$_POST['address'];

    $updateOfficers =finance_db_query($connection,"update officers
    set

   fname='$firstname',
    mname='$middlename',
   lname='$lastname',
   address='$address'


where mobileNumber='$mobile'
    ");

    if($updateOfficers)
    {

        echo  "
        <script>
        window.location.href='officers-list.php';
        </script>
        ";
    }

    else{
        echo "
        <script>
        alert('Error Occured');
        window.location.href='officers-list.php';
        </script>
        ";
    }
}
?>
