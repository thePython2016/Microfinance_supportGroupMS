<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
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

    <title>Dashboard - Analytics | Materio - Bootstrap Material Design Admin Template</title>

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
              <a class="btn addBtn" href="shares.php">Add Share</a>
</div>
<hr>







                <!-- Members List -->

                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Shares Form</div>

                    <div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-controls="tab1" aria-selected="true">Shares</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-controls="tab3" aria-selected="false">Shares List </a>
        </li>


    </ul>
    <div class="tab-content mb-5 tabForms" id="myTabContent"  >
        <div class="tab-pane fade show active" id="membersForm" role="tabpanel" aria-labelledby="tab1-tab">


       <!-- Farmers Form -->
       <?php if (isset($_SESSION['flash_success'])): ?>
<div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
  <i class="fas fa-check-circle me-2"></i>
  <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<?php if (isset($_SESSION['flash_error'])): ?>
<div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
  <i class="fas fa-exclamation-triangle me-2"></i>
  <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
       <form name="" action="shareAdd.php" method="POST">
        <div class="first-block">
        <div class="mb-3 nin">
          <input type="hidden" name="id">
    <label for="exampleInputEmail1" class="form-label" >Date</label>
    <input type="date" class="form-control" name="date" id="ninField" aria-describedby="emailHelp" required>

  </div>
              <div class="mb-3 mobile">
              <label for="exampleInputEmail1" class="form-label" >Member</label>
              <select id="gender" class="form-control" name="member" required name="gender">
              <option value="" disabled selected>--Select Member--</option>
                <?php
// SELECT MEMBERS FROM DB
require "connectDB.php";
$selectMember=finance_db_query($connection,"select * from members");
foreach($selectMember as $member)
{
                ?>


                <option value="<?php echo $member['mobileNumber']?>"><?php echo $member['mobileNumber'].' '.$member['fname'].' '.$member['lname']?></option>
               <?php
}
?>
            </select>

  </div>

</div>
  <div class="second-block">
  <div class="mb-3 fname">
    <label for="exampleInputPassword1" class="form-label">Amount</label>
    <input type="number" class="form-control" name="amount" id="fnameField">
  </div>



</div>

  <button type="submit"  class="btn  submitBtn" name="addShares">Submit</button>
</form>
        </div>

        <div class="tab-pane fade" id="editUpdate" role="tabpanel" aria-labelledby="tab2-tab">

            <div class="container">
            <table id="sharesTable" class="table  table-striped table-bordered" style="width:1000px !importnant">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member number </th>
                    <th>Amount</th>


                </tr>
            </thead>
            <tbody>

                  <?php
                  require "connectDB.php";
                  $selectShares=finance_db_query($connection,"select * from shares");
                  foreach($selectShares as $shares)
                  {
                    ?>
                  <tr>

                    <td><?php echo $shares['date']?></td>
                    <td><a class="url" href="member.php?number=<?php echo $shares['member']?>"><?php echo $shares['member']?></a></td>
                    <td><?php echo $shares['amount']?></td>

                </tr>

            <?php
                  }?>


            </tbody>
        </table>
        <style>
         .dt-layout-end{
          display:none !important;
         }
         </style>
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


    $('#sharesTable').dataTable( {

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
