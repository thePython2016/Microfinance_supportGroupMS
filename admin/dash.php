<?php
// Count members
$selectMembers=finance_db_query($connection,"select count(mobileNumber) as Count from members");
foreach($selectMembers as $count)
{
    $members=$count['Count'];
}
// Accumulated shares
$currentDate=date('Y');
$selectShares=finance_db_query($connection,"select sum(amount) as Total from shares where EXTRACT(YEAR FROM \"date\")='$currentDate'");
foreach($selectShares as $shares)
{
    $total=$shares['Total'];
}

// Money borrowed

$selectLoans=finance_db_query($connection,"select sum(amount) as borrowed from loans where EXTRACT(YEAR FROM \"date\")='$currentDate'");
foreach($selectLoans as $loans)
{
    $Total=$loans['borrowed'];
}
?>


