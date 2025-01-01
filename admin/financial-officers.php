
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

    <title>Financial Officers</title>

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
                   
                    <a class="btn addBtn" href="financial-officers.php">Add Financial Officer</a>
                    
</div>
<hr>


        

               
              
                     
                <!-- Members List -->

                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Financial Officers Form</div>
             
                    <div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-controls="tab1" aria-selected="true">Officers</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-controls="tab3" aria-selected="false">Officers List</a>
        </li>
       
   
    </ul>
    <div class="tab-content tabForms" id="myTabContent">
        <div class="tab-pane fade show active" id="membersForm" role="tabpanel" aria-labelledby="tab1-tab">

       
       <!-- Farmers Form -->
       <form name="" method="POST" action="officersAdd.php"> 
        <div class="first-block">
        <div class="mb-3 mobile">
    <label for="exampleInputEmail1" class="form-label" >Mobile number</label>
    <input type="text" id="mobile-number"  name="phone" class="form-control" maxlength="12" placeholder="076-123-7891" required>
    
    
  </div>
  <div class="mb-3 nin">

    <label for="exampleInputEmail1" class="form-label" >NIN</label>
    <input type="text" id="dash-input" name="nin" class="form-control"  maxlength="23" placeholder="12345678-12345-12345-09" required>
 </div>

   <div class="mb-3 occupation">
    <label for="exampleInputEmail1" class="form-label" >Occupation</label>
    <input type="text" class="form-control" id="ninField" aria-describedby="emailHelp">
    
  </div>
  
</div>
<!-- style input  fields -->
<style>
         input[type="text"] {
 
            background-color: white !important; /* Light blue background */
        }
        select {
          
            background-color: white; /* Light blue background for select field */
        }
    </style>
  <div class="second-block">
  <div class="mb-3 fname">
    <label for="exampleInputPassword1" class="form-label">First name</label>
    <input type="text" class="form-control" id="fname" name="fname">
  </div>

  <div class="mb-3 mname">
    <label for="exampleInputPassword1" class="form-label">Middle name</label>
    <input type="text"  class="form-control" id="mname" name="mname">
  </div>
  <div class="mb-3 lname">
    <label for="exampleInputPassword1" class="form-label">Last name</label>
    <input  type="text"  class="form-control" id="lname" name="lname">
  </div>
</div>
<label for="exampleInputPassword1" class="form-label">Birth date</label>
<div class="third-block">
  <div class="mb-3 day">
  <select class="form-select" id="day" name="day">
        <option selected disabled>Choose a day</option>
    </select>
  </div>
  <div class="mb-3 month">


    <select class="form-select"  id="month" name="month" >
        <option selected disabled>Choose a month</option>
    </select>
  </div>

      
  <div class="mb-3 year">
  <select class="form-select" id="year" name="year">
        <option >Choose a year</option>
    </select>
  </div>
</div>
<div class="fourth-block">
<div class="mb-3 address">
    <label for="exampleInputPassword1"   class="form-label">Gender</label>
    <select id="gender" class="form-control" name="gender" required name="gender">
                <option value="">--Select Gender--</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
  </div>

  <div class="mb-3 address">
    <label for="exampleInputPassword1"  class="form-label">Physical address</label>
    <input type="text" class="form-control" id="address" name="address">
  </div>
</div>
 
  <button type="submit" name="addOfficers" class="btn submitBtn">Submit</button>
</form>
        </div>
        <div class="tab-pane fade" id="editUpdate" role="tabpanel" aria-labelledby="tab2-tab">
            <h5></h5>
            <div >
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
$selectMembers=mysqli_query($connection,"select * from officers");
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
        <div class="tab-pane fade" id="uploadForm" role="tabpanel" aria-labelledby="tab3-tab">
            <h5>Content for Tab 3</h5>
            <input type="file" class="form-control" id="uploadField">
            <button type="submit" name="submit" class="btn btn-primary uploadBtn">Upload</button>
        </div>
        


        
        <div class="tab-pane fade" id="uploadSample" role="tabpanel" aria-labelledby="tab3-tab">
        <a href="uploadedSampleFiles/payments.csv"  class="payment-sample" download="payments.csv">Payments Sample file</a> <br>
     <a href="uploadedSampleFiles/staff.csv" class="staff-sample" download="staff.csv">Staff Sample file</a> <br>
     <a href="uploadedSampleFiles/student data.csv" class="student-sample"   download="student data.csv">Student Sample file</a>
            
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
    const yearSelect = document.getElementById('year');

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
    const monthSelect = document.getElementById('month');

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
    const daySelect = document.getElementById('day');

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

    <!-- nida form scripts -->
    <script>
        $(document).ready(function() {
            $('#dash-input').on('input', function() {
                var input = $(this).val().replace(/-/g, ''); // Remove existing dashes
                var formatted = '';

                // Format the string to follow the pattern: 12345678-12345-12345-09
                for (var i = 0; i < input.length; i++) {
                    if (i === 8 || i === 13 || i === 18) {
                        formatted += '-'; // Add dash after 8th, 13th, and 18th characters
                    }
                    formatted += input[i];
                }

                // Limit the formatted string to 19 characters + 3 dashes (total of 22 characters)
                $(this).val(formatted.slice(0, 23));
            });
        });
    </script>


<!-- Mobilenumber field scripts -->
<script>
        $(document).ready(function() {
            $('#mobile-number').on('input', function() {
                var input = $(this).val().replace(/-/g, ''); // Remove existing dashes
                var formatted = '';

                // Format the string to follow the pattern: XXX-XXX-XXXX
                for (var i = 0; i < input.length; i++) {
                    if (i === 3 || i === 6) {
                        formatted += '-'; // Add dash after 3rd and 6th characters
                    }
                    formatted += input[i];
                }

                // Limit the formatted string to 12 characters (XXX-XXX-XXXX)
                $(this).val(formatted.slice(0, 12));
            });
        });
    </script>


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
  </body>
</html>
