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
    <title>Member</title>
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


a{
   float:right !important;

   color:white!important;
}

a:hover{
   background: !important;
}
.button{
   background:#375E97!important;
   color:white;
 border-color:#375E97!important;
   
}
.form-control{
   box-shadow: none !important;
}
.navbar{
    background:#375E97 !important;
}
.contract-link{
    color:blue !important;

}
</style>
 
 

 
    

</head>
<body>

<!-- Navigation Menu -->
<nav class="navbar navbar-expand-lg  ">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">MFSGMS</a>
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




<div class="form-container">
<form name="" action="macro-member.php" method="POST">
    <select class="form-select" aria-label="Default select example" id="options" style="width:200px !important
    ;position:absolute;margin-left:150px" name="selected">
  <option selected disabled required>---Select---</option>
  <option value="share">Share</option>
  <option value="loan">Loan</option>

</select>
        <div class="input-group" style="width:400px !important;margin:0 auto">
                <!-- Input group with search icon -->
            
                <input type="text" name="phone" required class="form-control" placeholder="Enter your mobile Phone" aria-label="Search" aria-describedby="basic-addon1">
           <input type="submit" class="button" name="search" value="Search" style="margin-left:3px">
            </div>
    </form>
</div>
    <?php
           require "connectDB.php";
           if(isset($_POST['search']))
           {
            if(isset($_POST['selected']))
            {
                $selected=$_POST['selected'];
             $phone=$_POST['phone'];
             if($selected=='share')
             {
           $selectMembers=finance_db_query($connection,"select * from members
           
           INNER join shares ON members.mobileNumber=shares.member
           where members.mobileNumber='$phone'");
         if($selectMembers)
         {
            ?>
    <!-- Content Display Area -->
    <div id="contentDisplay" class="mt-3">
        <div id="option1" class="content-div">
        <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
                  <div class="card" style="height:700px !important">
                    <div class="row  g-0">
                      <div class="col-md-12">
                        
                 
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
                    <th>Birth day</th>
                    <th>Birth month</th>
                    <th>Birth year</th>
                
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

foreach($selectMembers as $members)
{
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
                    <td><?php echo $members['day']?></td>
                    <td><?php echo $members['month']?></td>
                    <td><?php echo $members['year']?></td>
             
                    <td><?php echo $members['address']?></td>
                    <td><?php echo $members['amount']?></td>
                    
                </tr>
             
             <?php
}
           }
        }


        // Loan

       else  if($selected=='loan')
        {
      $selectMembers=finance_db_query($connection,"select * from members
      
      INNER join loans ON members.mobileNumber=loans.member
      where members.mobileNumber='$phone'");
    if($selectMembers)
    {
       ?>
<!-- Content Display Area -->
<div id="contentDisplay" class="mt-3">
   <div id="option1" class="content-div">
   <div class="col-12 col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
             <div class="card" style="height:700px !important">
               <div class="row  g-0">
                 <div class="col-md-12">
                   
            
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
               <th>Birth day</th>
               <th>Birth month</th>
               <th>Birth year</th>
           
               <th>Physical address</th>
               <th>Loan Amount</th>

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

foreach($selectMembers as $members)
{
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
               <td><?php echo $members['day']?></td>
               <td><?php echo $members['month']?></td>
               <td><?php echo $members['year']?></td>
        
               <td><?php echo $members['address']?></td>
               <td><?php echo $members['amount']?></td>
               
           </tr>
        
        <?php
}
      }
   }
    }
}
?>
              
             
              
            </tbody>
        </table>
       
        <script>


$('#membersTable').dataTable( {
  info:false,
  // paging:false,
  pagingType:"simple",
  "language": {
    "decimal":        "",
    "emptyTable":     "No data available in table",
    "info":" ",
    // "infoEmpty":      "Showing 0 to 0 of 0 entries",
    "infoFiltered":   "",
    "infoPostFix":    "",
    "thousands":      ",",
    "lengthMenu":     "Show _MENU_ entries",
    // "loadingRecords": "Loading...",
    "ordering":"",
    "processing":     "",
    "search":         "Search:",
    "zeroRecords":    "No matching records found",

    //    "bProcessing": true,
    // "sAutoWidth": false,
    // "bDestroy":true,
    // "sPaginationType": "bootstrap", // full_numbers
    // "iDisplayStart ": 10,
    // "iDisplayLength": 10,
    // "bPaginate": false, //hide pagination
    // "bFilter": false, //hide Search bar
    // "bInfo": false, // hide showing entries
    "paginate": {
        // "first":      "First",
        // "last":       "Last",
        "next":       "<button  class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
        "previous":   "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>",
        
    }
  }
  

  
} );

</script>
        
        </div>      
                       
           



                  
           

                    
                    
                    

 
                      </div>
  
        
                    </div>
                  </div>
                </div>

          </div>
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
