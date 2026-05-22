<?php

if (session_status() === PHP_SESSION_NONE) { session_start(); }
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

    <title>Compose Message</title>

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
              <a class="btn addBtn" href="members.php">Add Member</a>
                    
                    
                    
</div>
<hr>
                     
   

          
                <div class="col-10 " style="margin:0 auto !important">
                  <div class="card   " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Compose Message</div>
                    <hr>
             <div class="compose-sms  mb-5">
                    <div class="mb-3">
                    <div class="container mt-5">
    
        
        <!-- Form with a dynamic drop-down -->
        <form action="user-message.php" method="POST">
        
        <div class="mb-3 lname">

    <label for="exampleInputPassword1" class="form-label">Sender name</label>
    <input type="text" class="form-control" name="lname" id="lname" required placeholder="Sender name">
  </div>
 
  <?php 
             require 'connectDB.php';
$selectEmail=finance_db_query($connection,"select * from members");
             ?>
            <div class="form-group mt-3">
                <label for="newItemSelect">Select receiver:</label>
                <select id="newItemSelect" class="form-control" name="email">
                <option selected value="">----Recipient----</option>
                  <?php
                  foreach($selectEmail ?: [] as $emails)
                  {
                  ?>
                    
                    <option value="<?php echo $emails['email']?>"><?php echo $emails['email'].' '.$emails['fname'].' '.$emails['lname']?></option>
                   
                    <?php
                  }
                  ?>
                </select>
             
            </div>

  


  <div class="mt-3 mb-3 lname">
    <label for="exampleInputPassword1" class="form-label">Subject</label>
    <input type="text" class="form-control" name="subject" id="subject" required placeholder="Subject">
  </div>
  
  <div class="mb-3 ">
  <label for="exampleFormControlTextarea1" class="form-label" >Message</label>
  <textarea class="form-control" id="message" rows="10" name="message" placeholder="Write your Message"></textarea>
</div>
  
<button style="margin-left:450px !important" type="submit" name="send" class="btn submitBtn mt-2" >Send</button>
</form>




              </div>
              </div>
              </div>
            </div>
           
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



    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>





       <!-- TABS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Select receiver -->
    <script>
        function addItem() {
            // Get the selected value and text from the second drop-down
            const newItemSelect = document.getElementById('newItemSelect');
            const newItemValue = newItemSelect.value;
            const newItemText = newItemSelect.options[newItemSelect.selectedIndex].text;
            
            // Check if a valid item is selected (not the placeholder option)
            if (newItemValue) {
                // Check if the item already exists in the main drop-down
                const itemSelect = document.getElementById('itemSelect');
                let itemExists = Array.from(itemSelect.options).some(option => option.value === newItemValue);
                
                // If item doesn't exist, add it to the main drop-down
                if (!itemExists) {
                    const option = document.createElement('option');
                    option.text = newItemText;
                    option.value = newItemValue;
                    itemSelect.add(option);  // Add new option to the main drop-down
                    // Optional: Use console log instead of alert for feedback
                    console.log(`${newItemText} added successfully!`);
                } else {
                    // Optional: Use console log instead of alert for feedback
                    console.log('Item already exists in the list.');
                }

           
                newItemSelect.value = '';
            } else {
               
                console.log("Please select an item to add.");
            }
        }
    </script>
  </body>
</html>
