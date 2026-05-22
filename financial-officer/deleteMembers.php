<?php

require "connectDB.php";
$id=$_GET['id'];
  
$delete=finance_db_query($connection,"delete from members where mobileNumber='$id'");
if($delete)
{
    echo "<script>
    
    window.location.href='members-list.php';
    </script>";
}
else 
{
    echo "<script>
    
    window.location.href='members-list.php';
    </script>";
}



?>