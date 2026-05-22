<?php

session_start();
if(!isset($_SESSION['username']))
{
  echo "
  <script>
  window.location.href='../index.php';
  </script>
  ";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Officer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery (required for Bootstrap JS) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .navbar-nav {
margin-left:1050px !important;

        }
        .btn{
            color:white !important;
        }
        .navbar{
            background:#375E97 !important;
        }
        .form-label{
            margin-bottom:20px !important;
        }
    </style>

    <!-- Data table -->
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script> 

    <style>

.dt-paging .dt-paging-button
  {
     display: none !important;
     background:none !important
 }
 </style> 
   </style>
    

</head>
<body>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg navbar-dark ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
        MFSGMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#"><?php echo $_SESSION['username']?></a>
                    </li>
                    <li class="nav-item">
                    <a class="btn  d-flex" href="../index.php" >Logout</a>
                    </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
  
    <div class="mb-5">
        
        <select class="form-select" id="exampleSelect" aria-label="Default select example">
        <option selected disabled>---Select---</option>
            <option value="1">Shares</option>
            <option value="2">Loans</option>
         
        </select>
    </div>
    
    <!-- Content Display Area -->
    <div id="contentDisplay" class="mt-3">
        <div id="option1" class="content-div" style="display: none;">
      
                    <table id="membersTable"  style="background:none !important" class="table  table-striped table-bordered" >
            <thead>
                <tr>
                    <th>Mobile number</th>
                    <th>NIN</th>
               
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Gender</th>
                    <th>Birth date</th>
                  
                
                    <th>Physical address</th>
                    <th>Share Amount</th>

                </tr>
            </thead>
            <tbody>
              <!-- hIDE Update form before selection -->
              <style>
              .hidden {
            display: none;
        }
           </style>
            <?php 
            require "connectDB.php";
$selectMembers=finance_db_query($connection,"select members.mobileNumber,members.nin,
members.fname,members.mname,members.lname,members.gender,members.day,
members.month,members.year,members.gender,members.address,sum(shares.amount) as totalShares,shares.member
 from members INNER JOIN shares ON members.mobileNumber=shares.member GROUP BY shares.member");
foreach($selectMembers as $members)
{
$totalShares=$members['totalShares'];
  echo "<tr class='dataRow' data-phone='" . $members['mobileNumber'] . "' data-nin='" . $members['nin'] . 
               "' data-fname='" . $members['fname'] . "' data-mname='" . $members['mname'] 
               . "' data-gender='" .$members['lname'] . "' data-day='" . $members['day'] . "'. data-month='" . $members['month'] . "'
               data-year='" . $members['year'] . "'data-gender='" . $members['gender']  . "'data-address='" . $members['address'] ."'>";
               ?>
                    <td><?php echo $members['mobileNumber']?></td>
                    <td><?php echo $members['nin']?></td>
                
                    <td><?php echo $members['fname']?></td>
                    <td><?php echo $members['mname']?></td>
                    <td><?php echo $members['lname']?></td>
                    <td><?php echo $members['gender']?></td>
                    <td><?php echo $members['day']. '/'.$members['month'].'/'.$members['year']?></td>
                
             
                    <td><?php echo $members['address']?></td>
                    <td><?php echo $totalShares ?></td>
                    
                </tr>
    
             <?php
}
?>
              
             
              <tr>
                <?php
$findTotal=finance_db_query($connection,"select sum(amount) as Total from shares");
foreach($findTotal as $shares)
{
    $Total=$shares['Total'];

}
                ?>

             <td colspan=8 style="font-weight:bold;text-transform:uppercase">Total</td>
             <td style="font-weight:bold"><?php echo $Total?> </td>
             </tr>
            </tbody>
        </table>
        </div>
        <div id="option2" class="content-div" style="display: none;">
        <div class="container">
                    <table id="membersTable"  style="background:none !important" class="table  table-striped table-bordered" >
            <thead>
                <tr>
                    <th>Mobile number</th>
                    <th>NIN</th>
               
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Gender</th>
                    <th>Birth date</th>
                  
                
                    <th>Physical address</th>
                    <th>Loan Amount</th>

                </tr>
            </thead>
            <tbody>
            
              <!-- DEDUCT LOAN ON PAYMNET -->

              <!-- Select Total loans -->
               <?php
                require "connectDB.php";


               ?>
              <!-- hIDE Update form before selection -->
              <style>
              .hidden {
            display: none;
        }
           </style>
            <?php 
           
$selectMembers=finance_db_query($connection,"select members.mobileNumber,members.nin,
members.fname,members.mname,members.lname,members.gender,members.day,
members.month,members.year,members.gender,members.address,sum(loans.amount) as totalLoans,loans.member
 from members INNER JOIN loans ON members.mobileNumber=loans.member GROUP BY loans.member");
foreach($selectMembers as $members)
{
$totalLoans=$members['totalLoans'];
  echo "<tr class='dataRow' data-phone='" . $members['mobileNumber'] . "' data-nin='" . $members['nin'] . 
               "' data-fname='" . $members['fname'] . "' data-mname='" . $members['mname'] 
               . "' data-gender='" .$members['lname'] . "' data-day='" . $members['day'] . "'. data-month='" . $members['month'] . "'
               data-year='" . $members['year'] . "'data-gender='" . $members['gender']  . "'data-address='" . $members['address'] ."'>";
               ?>
                    <td><?php echo $members['mobileNumber']?></td>
                    <td><?php echo $members['nin']?></td>
                
                    <td><?php echo $members['fname']?></td>
                    <td><?php echo $members['mname']?></td>
                    <td><?php echo $members['lname']?></td>
                    <td><?php echo $members['gender']?></td>
                    <td><?php echo $members['day']. '/'.$members['month'].'/'.$members['year']?></td>
                
             
                    <td><?php echo $members['address']?></td>
                    <td><?php echo $totalLoans ?></td>
                    
                </tr>
                
             <?php
}
?>           
       <tr>
                <?php
$findTotal=finance_db_query($connection,"select sum(amount) as Total from loans");
foreach($findTotal as $loans)
{
    $loanTotal=$loans['Total'];

}
                ?>

             <td colspan=8 style="font-weight:bold;text-transform:uppercase">Total</td>
             <td style="font-weight:bold"><?php echo $loanTotal?> </td>
             </tr>      
              
            </tbody>
        </table>
        </div>
        </div>
</div>

<!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Check if there is a stored selection and set the dropdown and content accordingly
    const storedValue = localStorage.getItem('selectedOption');
    if (storedValue) {
        $('#exampleSelect').val(storedValue);
        $('.content-div').hide();
        $('#option' + storedValue).show();
    }

    $('#exampleSelect').change(function() {
        // Hide all content divs
        $('.content-div').hide();

        // Get the selected value
        var selectedValue = $(this).val();

        // Show the corresponding content div based on the selected value
        if (selectedValue) {
            $('#option' + selectedValue).show();
            // Store the selected value in local storage
            localStorage.setItem('selectedOption', selectedValue);
        }
    });
});
</script>
</body>
</html>
