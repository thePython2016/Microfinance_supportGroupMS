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
require "chartsCodes.php";
require 'dash.php';
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
    <meta charset="utf-8" />
    <meta
    
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Home</title>

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

     <?php 
     require 'menu.php';
     ?>
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
                 
                </div>
              </div>
              
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">
             

           <?php require "user.php" ?>
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
                <!-- Congratulations card -->
              
                <!--/ Congratulations card -->

                <!-- Transactions -->
                <div class="col-md-8">
                  <div class="card h-100" >
              
                    <div class="card-body pt-lg-10">
                      <div class="row g-6">
                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockMember">
                            <div class="icon-section">
                              <div class="avatar-initial ">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="members-icon" 
                                viewBox="0 0 640 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                              </div>
                            </div>
                            <div class="ms-3 icon-text" >
                              <p class="mb-0">Members</p>
                              <h5 class="mb-0"><?php echo $members?></h5>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockShares">
                            <div class="icon-section">
                              <div class="avatar-initial  ">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="share-icon" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L80 128c-8.8 0-16-7.2-16-16s7.2-16 16-16l368 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L64 32zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>

                              </div>
                            </div>
                            <div class="ms-3 icon-text" >
                              <p class="mb-0">Shares (Tsh)</p>
                              <h5 class="mb-0"><?php  echo $total ?></h5>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockLoan">
                            <div class="icon-section">
                              <div class="avatar-initial">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="loan-icon" viewBox="0 0 576 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                              </div>
                            </div>
                            <div class="ms-3 icon-text" >
                              <p class="mb-0">Loans (Tsh)</p>
                              <h5 class="mb-0"><?php echo $Total ?></h5>
                            </div>
                          </div>
                        </div>
                   
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Transactions -->

                <!-- Weekly Overview Chart -->
                <div class="col-xl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2" style="color:rgb(61, 60, 60) !important">Monthly Shares</h5>
                   
                    </div>
                    <div class="card-body pt-lg-8">
                      <canvas id="shares"></canvas>


                      <!-- Chart Shares -->
                       
                          <!-- Script Barchart-->
                          <script>
    
                      const labels1 =<?php echo json_encode($shareMonths)?>;
                    const data1 = {
                      labels: labels1,
                      datasets: [{
                        label: 'Monthly Shares',
                        data: <?php echo json_encode($shareAmount)?>,
                        backgroundColor: [
                        '#EB8921',
                      '#375E97',
                      ' #f1ba21f1',
                      '#FB6542',
                     
                         
                        ],
                        borderColor: [
                         '#EB8921',
                         
                        ],
                        borderWidth: 1
                      }]
                    };
                    const config1 = {
                      type: 'line',
                      data: data1,
                      options: {
                     
                        
                        scales: {
                          y: {
                            beginAtZero: true
                          }
                          
                        }
                      },
                    };
                    var shares = new Chart(
                        document.getElementById('shares'),
                        config1
                      );
                    </script>
                  
                           
                    </div>
                  </div>
                </div>
                <!--/ Weekly Overview Chart -->

                <!-- Total Earnings -->
                <div class="col-lg-8 col-md-6">
                  <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2" style="color:rgb(61, 60, 60) !important">Monthly Loans</h5>
                      
                    </div>
                    <div class="card-body pt-lg-8">
                     
                     <canvas id="loans"></canvas>
                     <!-- Loans Chart -->
                     <script>
    
                      const labels3 =<?php echo json_encode($months)?>;
                    const data3 = {
                      labels: labels3,
                      datasets: [{
                        label: 'Monthly Loans',
                        data: <?php echo json_encode($amount)?>,
                        backgroundColor: [
                        '#EB8921',
                      '#375E97',
                      ' #f1ba21f1',
                      '#FB6542',
                     
                         
                        ],
                        borderColor: [
                         '#EB8921',
                         
                        ],
                        borderWidth: 1
                      }]
                    };
                    const config3 = {
                      type: 'bar',
                      data: data3,
                      options: {
                     
                        
                        scales: {
                          y: {
                            beginAtZero: true
                          }
                          
                        }
                      },
                    };
                    var loans = new Chart(
                        document.getElementById('loans'),
                        config3
                      );
                    </script>
                            
                            
                    </div>
                  </div>
                </div>
                <!--/ Total Earnings -->

              

                <!-- Sales by Countries -->
                <div class="col-xl-4 col-md-6">
                  <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                      <h5 class="card-title m-0 me-2" style="color:rgb(61, 60, 60) !important">Highest Loan Amount</h5>
                   
                    </div>
                    <div class="card-body">
                    
                    <canvas id="loans2"></canvas>
                    <script>
    
                      const labels =['January','February','March','April','May','June','July','August','September','October','November','December'];
                    const data = {
                      labels: labels,
                      datasets: [{
                        label: 'Monthly Loans',
                        data: [6,10,11,12,80,78,32],
                        backgroundColor: [
                        '#EB8921',
                      '#375E97',
                      ' #f1ba21f1',
                      '#FB6542',
                     
                         
                        ],
                        borderColor: [
                         '#EB8921',
                         
                        ],
                        borderWidth: 1
                      }]
                    };
                    const config = {
                      type: 'line',
                      data: data3,
                      options: {
                     
                        
                        scales: {
                          y: {
                            beginAtZero: true
                          }
                          
                        }
                      },
                    };
                    var loans2 = new Chart(
                        document.getElementById('loans2'),
                        config
                      );
                    </script>
                 
                        
                    
                         
                    </div>
                  </div>
                </div>
                <!--/ Sales by Countries -->

              
                <style>

.dt-paging{
          display:none !important;
         }
         </style>
                <!-- Members List -->

                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card ">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Members List</div>
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
    <script src="assets/vendor/js/bootstrap.js"></script>
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
    
    // new DataTable('#myTable', {
    //     language: {
    //         paginate: {
    //             first: 'First page'
    //         }
    //     }
    // });
    
    
    
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
