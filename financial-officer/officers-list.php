
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

    <title>Officers List</title>

    <meta name="description" content="" />
   <!-- Datatable Top begin-->
   <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
  
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

  

   <!-- Datatables End -->

   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
   

   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
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
                </li>
                <!--/ User -->
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
              <a class="btn addBtn" href="financial-officers.php">Add Financial Officers</a>
                    
</div>
<hr>


        

               
              
                     
                <!-- Members List -->

                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card" style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Officers List</div>
             
                    <div class="container">
                    <style>
         .dt-paging{
          display:none !important;
         }
         </style>
            <table id="officersTable"  style="background:none !important" class="table  table-striped table-bordered" >
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
              <!-- hIDE nav buttons -->
              <style>
              .hidden {
            display: none;
        }
           </style>
            <?php 
            require "connectDB.php";
$selectOfficers=mysqli_query($connection,"select * from officers");
foreach($selectOfficers as $members)
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
        <!-- hide form before selection -->
        <style>
              .hidden {
            display: none;
        }
           </style>

               <!-- UPDATE FORM -->
                
               <div class="row">
        
        <div class="col-7">
        <!-- Show update button when row is selected -->
      
<form id="editForm" class="hidden" method="POST" action="updateAll.php">
<h3 style="margin-top:30px">Update Record</h3>
<hr style="color:blue !important">

      <div class="row">
        <div class="col-8">
          <div class="block1">
        <div class="mb-3">

        

  <input type="text" class="form-control" name="mobile" id="phone">
</div>
        <div class="mb-3">

  <input type="hidden" class="form-control" name="nin" id="nin" >
</div>
</div>
          <div class="block1">
        <div class="mb-3">
     
        
  <label for="exampleInputPassword1" class="form-label">First name</label>
  <input type="text" class="form-control" name="firstname" id="fname">
</div>
        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Middle  name</label>
  <input type="text" class="form-control" name="middlename" id="mname">
</div>
</div>
<div class="block2">
        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Last name</label>
  <input type="text" class="form-control" name="lastname" id="lname">
</div>
<div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Gender</label>
  <input type="text" class="form-control" name="gender" id="gender" disabled>
</div>
</div>
<div class="block3">
        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Birth day</label>
  <input type="text" class="form-control" name="day" id="day" disabled>
</div>
        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Birth month</label>
  <input type="text" class="form-control" name="month" id="month" disabled>
</div>
</div>
<div class="block4">
        <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Birth year</label>
  <input type="text" class="form-control" name="year" id="year" disabled>
</div>
       
<div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">Address</label>
  <input type="text" class="form-control" name="address" id="address">
</div>
</div>
  </div>
</div>

      <button type="submit" id="updateBtn" style="margin-bottom:20px;margin-left:100px" name="updateOfficers" class="btn  submitBtn">Update</button>

</form>
</div>
 
  

      
<?php
         
         ?>
        <div class="col-5">
        <div   style="margin-top:20px !important;margin-bottom:20px !important">
    


        <button type="button" id="showFormBtn" class="btn hidden submitBtn" >Update Selected Record</button>
    <button id="delete-button" type="submit"  class="btn  submitBtn">Delete selected</button>
   
</div>
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
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <!-- <script src="assets/vendor/js/bootstrap.js"></script> -->
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <!-- Datatables bottom -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
<link href="hhttps://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">



    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <!-- Dataset SECRIPTS -->
    <script>

    
      
    
    // new DataTable('#myTable', {
    //     language: {
    //         paginate: {
    //             first: 'First page'
    //         }
    //     }
    // });
    
    // table one
    $('#officersTable').dataTable( {
      
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


    <!-- DELETE AND UPDATE SCRIPTS -->
     <!-- Delete scripts -->
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



<!-- UPDATE RECORDS -->



<script>
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('officersTable');
            const showFormBtn = document.getElementById('showFormBtn');
            const form = document.getElementById('editForm');
            const updateBtn = document.getElementById('updateBtn');

            const phone = document.getElementById('phone');
            const nin = document.getElementById('nin');
            const fname = document.getElementById('fname');
            const mname = document.getElementById('mname');
            const lname = document.getElementById('lname');
            const day= document.getElementById('day');
            const month = document.getElementById('month');
            const year = document.getElementById('year');
            const gender = document.getElementById('gender');
            const address = document.getElementById('address');

            let selectedRow = null;

            // Handle click on any table row
            table.addEventListener('click', (e) => {
                const row = e.target.closest('tr');
                if (row) {
                    const rowData = Array.from(row.children);

                    // Populate form with row data
                   phone.value = rowData[0].innerText;
                    nin.value = rowData[1].innerText;
                   fname.value = rowData[2].innerText;
                   mname.value = rowData[3].innerText;
                   lname.value = rowData[4].innerText;
                   gender.value = rowData[5].innerText;
                   day.value = rowData[6].innerText;
                   month.value = rowData[7].innerText;
                   year.value = rowData[8].innerText;
                   address.value = rowData[9].innerText;

                    // Store the selected row for future updates
                    selectedRow = row;

                    // Show the "Update Selected Row" button
                    showFormBtn.classList.remove('hidden');
                }
            });

            // Show the form when "Update Selected Row" button is clicked
            showFormBtn.addEventListener('click', () => {
                if (selectedRow) {
                    form.classList.remove('hidden');
                }
                
            });

            // // Handle form submission for updating the row
            // updateBtn.addEventListener('click', () => {
            //     if (selectedRow) {
            //         // Update the selected row with form data
            //         selectedRow.children[1].innerText =  phone.value;
            //         selectedRow.children[2].innerText = nin.value;
            //         selectedRow.children[3].innerText = fname.value;
            //         selectedRow.children[3].innerText = mname.value;
            //         selectedRow.children[3].innerText = lname.value;
            //         selectedRow.children[3].innerText = day.value;
            //         selectedRow.children[3].innerText = month.value;
            //         selectedRow.children[3].innerText = year.value;
            //         selectedRow.children[3].innerText = gender.value;
            //         selectedRow.children[3].innerText =address.value;
                

            //         // Optionally hide the form after update
            //         form.classList.add('hidden');
            //         showFormBtn.classList.add('hidden');
            //     }
            // });
        });
    </script>

  </body>
</html>
