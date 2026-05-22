<?php

require "connectDB.php";
$id=$_GET['id'];
  
$delete=finance_db_query($connection,"delete from shares where shareID='$id'");
if($delete)
{
    echo "<script>
    
    window.location.href='shares-list.php';
    </script>";
}
else 
{
    echo "<script>
    
    window.location.href='shares-list.php';
    </script>";
}



?>