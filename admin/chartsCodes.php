<?php

// Monthly loans
require "connectDB.php";
$selectLoans=mysqli_query($connection, "select monthname(date) as months,sum(amount) as Total  from loans 
GROUP BY monthname(date)");
foreach($selectLoans as $loans)
{
    $months[]=$loans['months'];
    $amount[]=$loans['Total'];
}

// Monthly shares
$selectShares=mysqli_query($connection, "select monthname(date) as months,sum(amount) as Total  from shares
GROUP BY monthname(date)");
foreach($selectShares as $shares)
{
    $shareMonths[]=$shares['months'];
    $shareAmount[]=$shares['Total'];
}
?>