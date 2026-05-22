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
<!doctype html>

<html
  lang="en"
  class="light-style layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
  <head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Report</title>

    <meta name="description" content="" />
   <!-- Datatable Top begin-->
      <!-- Datatable -->
      <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script> 

    <!-- Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- Required for Excel Export -->
   <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
   <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

  

   <!-- Datatables End -->

   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
   

   <!-- <script src="https://code.jquery.com/jquery-3.7.1.js"></script> -->
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

 

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="assets/js/config.js"></script>
    <!-- Charts -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- charts end -->
    
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

     <?php require "menu.php" ?>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page"  >
          <!-- Navbar -->

          <nav  
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="ri-menu-fill ri-24px"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse" >
              <!-- Search -->
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <!-- <i class="ri-search-line ri-22px me-2"></i>
                  <input
                    type="text"
                    class="form-control border-0 shadow-none"
                    placeholder="Search..."
                    aria-label="Search..." /> -->
                </div>
              </div>
              
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
              <?php require "user.php" ?>
              </ul>
            </div>
            
          </nav>
          <hr style="background:red !important;border:1px solid #00246B, !important">

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row gy-6">
             
              <div class="col-lg-12 col-md-12 col-12 mb-4">
                    <button type="button" class="btn btn-success addBtn">Add Loan</button>
                    
</div>
<hr>


        

               
              
                     
                <!-- Members List -->

                <!-- Report on selection form -->
                <div class="col-12">
                  <div class="card " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Generate report</div>
             
                    <div  class="nav-tabs mb-5 w-10" >
                    
                    <select class="form-select" style="width:1000px;margin:0 auto;" aria-label="Default select example">
                    <option value="choose">----Select----</option>
            <option value="members">Members</option>
            <option value="shares">Member by Shares</option>
            <option value="loans">Member by Loan</option>

            <!-- Block after selection -->

</select>
</div>
<div style="margin-bottom:20px !important;width:800px">
<!-- MEMBERS BLOCK -->
    <div class="members box container">
      <!-- Members Table -->
      <div class="row mb-3 dateBlock">
       <div class="col-md-3">
           <label for="minDate">Date From:</label>
           <input type="date" id="minDate" class="form-control"> <!-- Changed input type to 'date' -->
       </div>
       <div class="col-md-3">
           <label for="maxDate">Date To:</label>
           <input type="date" id="maxDate" class="form-control"> <!-- Changed input type to 'date' -->
       
          </div>
 
       
   </div>
  
   <style>
    /* Style table BUTTONS */
    .dt-paging{
      display:none !important;
    }
    .dt-buttons{
      margin-left:500px !important;
    }
    .mb-3 {
      position:relative !important;
      margin-left:300px !important;
      
    }
    .dt-length{
      width:200px !important;
      position:absolute !important;
    }
    .table{
      margin-top:50px !important;
    }
   </style>
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
$selectMembers=finance_db_query($connection,"select * from members");
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
                    
                </tr>
             
             <?php
}
?>
              
             
              
            </tbody>
        </table>
  
  
  </div>

  <!-- MEMBERS BY SHARES BLOCK-->
  <div class="shares box container">
      <!-- Members Table -->
      <div class="row mb-3 dateBlock">
       <div class="col-md-3">
           <label for="minDate">Date From:</label>
           <input type="date" id="minDate" class="form-control"> <!-- Changed input type to 'date' -->
       </div>
       <div class="col-md-3">
           <label for="maxDate">Date To:</label>
           <input type="date" id="maxDate" class="form-control"> <!-- Changed input type to 'date' -->
       
          </div>
 
       
   </div>
  
   <style>
    /* Style table BUTTONS */
    .dt-paging{
      display:none !important;
    }
    .dt-buttons{
      margin-left:500px !important;
    }
    .mb-3 {
      position:relative !important;
      margin-left:300px !important;
      
    }
    .dt-length{
      width:200px !important;
      position:absolute !important;
    }
    .table{
      margin-top:50px !important;
    }
   </style>
      <table id="sharesTable"  style="background:none !important" class="table  table-striped table-bordered" >
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
$selectMembers=finance_db_query($connection,"select * from members");
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
                    
                </tr>
             
             <?php
}
?>
              
             
              
            </tbody>
        </table>
  
  
  </div>

  <!-- MEMBERS BY LOAN -->
   <!-- MEMBERS BLOCK -->
   <div class="loans box container">
      <!-- Members Table -->
      <div class="row mb-3 dateBlock">
       <div class="col-md-3">
           <label for="minDate">Date From:</label>
           <input type="date" id="minDate" class="form-control"> <!-- Changed input type to 'date' -->
       </div>
       <div class="col-md-3">
           <label for="maxDate">Date To:</label>
           <input type="date" id="maxDate" class="form-control"> <!-- Changed input type to 'date' -->
       
          </div>
 
       
   </div>
  
   <style>
    /* Style table BUTTONS */
    .dt-paging{
      display:none !important;
    }
    .dt-buttons{
      margin-left:500px !important;
    }
    .mb-3 {
      position:relative !important;
      margin-left:300px !important;
      
    }
    .dt-length{
      width:200px !important;
      position:absolute !important;
    }
    .table{
      margin-top:50px !important;
    }
   </style>
      <table id="loansTable"  style="background:none !important" class="table  table-striped table-bordered" >
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
$selectMembers=finance_db_query($connection,"select * from members");
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
                    
                </tr>
             
             <?php
}
?>
              
             
              
            </tbody>
        </table>
  
  
  </div>

</div>

      

                    </div>
                   


                <!--/ Data Tables -->
              </div>
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body mb-2 mb-md-0">
                    MFSGMS
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    All Rights Reserved<span class="text-danger">
                  </div>
                  
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->



    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <!-- <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script> -->
    <!-- <script src="assets/vendor/js/bootstrap.js"></script> -->
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Datatables bottom -->
   



    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <!-- Dataset SECRIPTS -->
    
    <!-- Get Years -->
<script>
    // Set the starting and ending year
    const startYear = 1950;
    const endYear = 2006;

    // Get the dropdown element
    const yearSelect = document.getElementById('yearField');

    // Loop through the years from startYear to endYear
    for (let year = startYear; year <= endYear; year++) {
        let option = document.createElement('option');
        option.value = year; // Set the value as the year
        option.textContent = year; // Set the display text as the year
        yearSelect.appendChild(option); // Append the option to the select element
    }
</script>
<!-- Months -->

 <!-- Script -->
 <script>
    // Array of month names
    const months = [
        "January", "February", "March", "April", "May", "June", 
        "July", "August", "September", "October", "November", "December"
    ];

    // Get the dropdown element
    const monthSelect = document.getElementById('monthField');

    // Loop through the months array and add options dynamically
    months.forEach((month, index) => {
        let option = document.createElement('option');
        option.value = index + 1; // Set the value as the month number
        option.textContent = month; // Set the display text as the month name
        monthSelect.appendChild(option); // Append the option to the select element
    });
</script>

<!-- Generate Days -->
<script>
    // Get the day dropdown element
    const daySelect = document.getElementById('dayField');

    // Populate day dropdown with values from 1 to 31
    for (let day = 1; day <= 31; day++) {
        let option = document.createElement('option');
        option.value = day; // Set the value as the day number
        option.textContent = day; // Set the display text as the day number
        daySelect.appendChild(option); // Append the option to the select element
    }
</script>
       </script>
       <!-- TABS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>



    <script>
   $(document).ready(function() {
       // DataTable initialization
       var table = $('#membersTable').DataTable({
           dom: 'lBfrtip',
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
  },
  
          buttons: [
               {
                   extend: 'excelHtml5',
                  //  text: '<i class="fas fa-file-excel"></i> Export to Excel',
                  text: '<i class="fas fa-file-excel excelIcon fs-4"></i>',
                   className: 'btn btn-success excelBtn',
                   titleAttr: 'Export table data to Excel'
               },
               {
                   extend: 'pdfHtml5',
                  //  text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                  text: '<i class="fas fa-file-pdf pdfIcon fs-4"></i>', 
                   className: 'btn btn-danger pdfBtn',
                   titleAttr: 'Export table data to PDF'
               },
               {
                   extend: 'print',
                  //  text: '<i class="fas fa-print"></i> Print Table',
                  text: '<i class="fas fa-print printIcon fs-4"></i>',
                   className: 'btn btn-primary printBtn',
                   titleAttr: 'Print table data'
               }
           ],
           pageLength: 10,
           lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
           responsive: true
       });
       
        // Date filter functionality
        $('#filterBtn').click(function() {
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();

            // Filter logic based on date
            if (dateFrom !== "" && dateTo !== "") {
                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var dateCell = this.data()[3]; // Get the date from the 4th column (index 3)
                    if (dateCell >= dateFrom && dateCell <= dateTo) {
                        this.node().style.display = ''; // Show row if within range
                    } else {
                        this.node().style.display = 'none'; // Hide row if not in range
                    }
                });
            } else {
                table.rows().every(function() {
                    this.node().style.display = ''; // Show all rows if no date filter is applied
                });
            }
        });
       // Custom filtering for date range
       $.fn.dataTable.ext.search.push(
           function(settings, data, dataIndex) {
               var min = $('#minDate').val();
               var max = $('#maxDate').val();
               var startDate = data[4]; // Use the 'Start date' column (index 4)

               // Convert dates to proper format for comparison
               if (min) {
                   min = new Date(min);
               }
               if (max) {
                   max = new Date(max);
               }
               var date = new Date(startDate);

               if (
                   (!min || date >= min) && (!max || date <= max)
               ) {
                   return true;
               }
               return false;
           }
       );

       // Event listener to the two date inputs to redraw on change
       $('#minDate, #maxDate').on('change', function() {
           table.draw();
       });
   });
   </script>


<!-- shares block scripts -->
<script>
   $(document).ready(function() {
       // DataTable initialization
       var table = $('#sharesTable').DataTable({
           dom: 'lBfrtip',
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
  },
  
          buttons: [
               {
                   extend: 'excelHtml5',
                  //  text: '<i class="fas fa-file-excel"></i> Export to Excel',
                  text: '<i class="fas fa-file-excel excelIcon fs-4"></i>',
                   className: 'btn btn-success excelBtn',
                   titleAttr: 'Export table data to Excel'
               },
               {
                   extend: 'pdfHtml5',
                  //  text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                  text: '<i class="fas fa-file-pdf pdfIcon fs-4"></i>', 
                   className: 'btn btn-danger pdfBtn',
                   titleAttr: 'Export table data to PDF'
               },
               {
                   extend: 'print',
                  //  text: '<i class="fas fa-print"></i> Print Table',
                  text: '<i class="fas fa-print printIcon fs-4"></i>',
                   className: 'btn btn-primary printBtn',
                   titleAttr: 'Print table data'
               }
           ],
           pageLength: 10,
           lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
           responsive: true
       });
       
        // Date filter functionality
        $('#filterBtn').click(function() {
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();

            // Filter logic based on date
            if (dateFrom !== "" && dateTo !== "") {
                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var dateCell = this.data()[3]; // Get the date from the 4th column (index 3)
                    if (dateCell >= dateFrom && dateCell <= dateTo) {
                        this.node().style.display = ''; // Show row if within range
                    } else {
                        this.node().style.display = 'none'; // Hide row if not in range
                    }
                });
            } else {
                table.rows().every(function() {
                    this.node().style.display = ''; // Show all rows if no date filter is applied
                });
            }
        });
       // Custom filtering for date range
       $.fn.dataTable.ext.search.push(
           function(settings, data, dataIndex) {
               var min = $('#minDate').val();
               var max = $('#maxDate').val();
               var startDate = data[4]; // Use the 'Start date' column (index 4)

               // Convert dates to proper format for comparison
               if (min) {
                   min = new Date(min);
               }
               if (max) {
                   max = new Date(max);
               }
               var date = new Date(startDate);

               if (
                   (!min || date >= min) && (!max || date <= max)
               ) {
                   return true;
               }
               return false;
           }
       );

       // Event listener to the two date inputs to redraw on change
       $('#minDate, #maxDate').on('change', function() {
           table.draw();
       });
   });
   </script>

<!-- Loans BLOCK -->
<script>
   $(document).ready(function() {
       // DataTable initialization
       var table = $('#loansTable').DataTable({
           dom: 'lBfrtip',
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
  },
  
          buttons: [
               {
                   extend: 'excelHtml5',
                  //  text: '<i class="fas fa-file-excel"></i> Export to Excel',
                  text: '<i class="fas fa-file-excel excelIcon fs-4"></i>',
                   className: 'btn btn-success excelBtn',
                   titleAttr: 'Export table data to Excel'
               },
               {
                   extend: 'pdfHtml5',
                  //  text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                  text: '<i class="fas fa-file-pdf pdfIcon fs-4"></i>', 
                   className: 'btn btn-danger pdfBtn',
                   titleAttr: 'Export table data to PDF'
               },
               {
                   extend: 'print',
                  //  text: '<i class="fas fa-print"></i> Print Table',
                  text: '<i class="fas fa-print printIcon fs-4"></i>',
                   className: 'btn btn-primary printBtn',
                   titleAttr: 'Print table data'
               }
           ],
           pageLength: 10,
           lengthMenu: [ [5, 10, 25, 50, -1], [5, 10, 25, 50, "All"] ],
           responsive: true
       });
       
        // Date filter functionality
        $('#filterBtn').click(function() {
            var dateFrom = $('#dateFrom').val();
            var dateTo = $('#dateTo').val();

            // Filter logic based on date
            if (dateFrom !== "" && dateTo !== "") {
                table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                    var dateCell = this.data()[3]; // Get the date from the 4th column (index 3)
                    if (dateCell >= dateFrom && dateCell <= dateTo) {
                        this.node().style.display = ''; // Show row if within range
                    } else {
                        this.node().style.display = 'none'; // Hide row if not in range
                    }
                });
            } else {
                table.rows().every(function() {
                    this.node().style.display = ''; // Show all rows if no date filter is applied
                });
            }
        });
       // Custom filtering for date range
       $.fn.dataTable.ext.search.push(
           function(settings, data, dataIndex) {
               var min = $('#minDate').val();
               var max = $('#maxDate').val();
               var startDate = data[4]; // Use the 'Start date' column (index 4)

               // Convert dates to proper format for comparison
               if (min) {
                   min = new Date(min);
               }
               if (max) {
                   max = new Date(max);
               }
               var date = new Date(startDate);

               if (
                   (!min || date >= min) && (!max || date <= max)
               ) {
                   return true;
               }
               return false;
           }
       );

       // Event listener to the two date inputs to redraw on change
       $('#minDate, #maxDate').on('change', function() {
           table.draw();
       });
   });
   </script>



<!-- WHEN ROW SELECTED BACKGROUND -->
<script>
        $(document).ready(function() {
            let selectedId = null; // Variable to hold the selected record ID

            // Row click event
            $("tr").click(function() {
                $("tr").removeClass("selected"); // Deselect previously selected row
                $(this).addClass("selected"); // Highlight the selected row
                selectedId = $(this).data("phone"); // Get the ID of the clicked row
            });

            // Delete button click event
            $("#delete-button").click(function() {
                if (selectedId === null) {
                    alert("Please select a record to delete.");
                    return;
                }
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = 'deleteMembers.php?id=' + selectedId; // Redirect to delete.php
                }
            });
        });
    </script>

    <!-- Scripts to decide DROP DOWN -->
    <script>

$(document).ready(function(){
        $("select").change(function(){
            $( "select option:selected").each(function(){
                if($(this).attr("value")=="members"){
                    $(".box").hide();
                    $(".members").show();
                }
                if($(this).attr("value")=="shares"){
                    $(".box").hide();
                    $(".shares").show();
                }
                if($(this).attr("value")=="loans"){
                    $(".box").hide();
                    $(".loans").show();
                }
                if($(this).attr("value")=="choose"){
                    $(".box").hide();
                    $(".choose").show();
                }
            });
        }).change();
    });
    </script>
    
    <style>

      

 
    .green{ background: #00ff00; }
    .blue{ background: #0000ff; }
    .choose{background: #ffffff;}
    </style>
             
  </body>
</html>
