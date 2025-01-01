<?php
// Count members
$selectMembers=mysqli_query($connection,"select count(mobileNumber) as Count from members");
foreach($selectMembers as $count)
{
    $members=$count['Count'];
}
// Accumulated shares
$currentDate=date('Y');
$selectShares=mysqli_query($connection,"select sum(amount) as Total from shares where year(date)
='$currentDate'");
foreach($selectShares as $shares)
{
    $total=$shares['Total'];
}

// Money borrowed

$selectLoans=mysqli_query($connection,"select sum(amount) as borrowed from loans where year(date)
='$currentDate'");
foreach($selectLoans as $loans)
{
    $Total=$loans['borrowed'];
}
?>


