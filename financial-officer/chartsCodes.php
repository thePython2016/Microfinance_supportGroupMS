<?php

// Monthly loans
require "connectDB.php";
$selectLoans=finance_db_query($connection, "select TRIM(TO_CHAR(\"date\", 'Month')) as months, sum(amount) as Total from loans 
GROUP BY TRIM(TO_CHAR(\"date\", 'Month')), EXTRACT(MONTH FROM \"date\") ORDER BY EXTRACT(MONTH FROM \"date\")");
foreach($selectLoans as $loans)
{
    $months[]=$loans['months'];
    $amount[]=$loans['Total'];
}

// Monthly shares
$selectShares=finance_db_query($connection, "select TRIM(TO_CHAR(\"date\", 'Month')) as months, sum(amount) as Total from shares
GROUP BY TRIM(TO_CHAR(\"date\", 'Month')), EXTRACT(MONTH FROM \"date\") ORDER BY EXTRACT(MONTH FROM \"date\")");
foreach($selectShares as $shares)
{
    $shareMonths[]=$shares['months'];
    $shareAmount[]=$shares['Total'];
}
?>