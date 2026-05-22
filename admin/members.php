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

    <title>Members</title>

    <meta name="description" content="" />
   <!-- Datatable Top begin-->
   <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

   <!-- Datatables End -->

   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
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

              <div class="col-lg-12 col-md-12 col-12 mb-4" >
              <a class="btn addBtn" href="members.php">Add Members</a>

</div>
<hr>


                <!-- Members List -->

                <!-- Data Tables -->
                <div class="col-12" >
                  <div class="card " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Members Form</div>

                    <div class="container mt-4" >
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-controls="tab1" aria-selected="true">Members</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-controls="tab3" aria-selected="false">Edit/Update</a>
        </li>


    </ul>
    <div class="tab-content mb-5 tabForms" id="myTabContent " >
        <div class="tab-pane fade show active" id="membersForm" role="tabpanel" aria-labelledby="tab1-tab">

    <style>
         input[type="text"] {

            background-color: white !important; /* Light blue background */
        }
        select {

            background-color: white; /* Light blue background for select field */
        }
    </style>

       <!-- ===== FLASH MESSAGES — displayed at the very top of the form ===== -->
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

       <!-- Members Form — field names now match DB columns exactly -->
       <form name="" method="POST" action="membersAdd.php">
        <div class="first-block">

          <!-- DB col: mobilenumber -->
          <div class="mb-3 mobile">
            <label for="mobilenumber" class="form-label">Mobile number</label>
            <input type="text" id="mobilenumber" name="mobilenumber" class="form-control"
                   maxlength="20" placeholder="0761237891" required>
          </div>

          <!-- DB col: email -->
          <div class="mb-3 nin">
            <label for="email" class="form-label">Email</label>
            <input type="text" id="email" name="email" class="form-control"
                   maxlength="120" placeholder="user@gmail.com" required>
          </div>

          <!-- DB col: nin -->
          <div class="mb-3 nin">
            <label for="dash-input" class="form-label">NIN</label>
            <input type="text" id="dash-input" name="nin" class="form-control"
                   required placeholder="12345678-12345-12345-09">
          </div>

        </div>

        <div class="second-block">

          <!-- DB col: fname -->
          <div class="mb-3 fname">
            <label for="fname" class="form-label">First name</label>
            <input type="text" class="form-control" name="fname" id="fname" required>
          </div>

          <!-- DB col: mname -->
          <div class="mb-3 mname">
            <label for="mname" class="form-label">Middle name</label>
            <input type="text" class="form-control" name="mname" id="mname" required>
          </div>

          <!-- DB col: lname -->
          <div class="mb-3 lname">
            <label for="lname" class="form-label">Last name</label>
            <input type="text" class="form-control" name="lname" id="lname" required>
          </div>

        </div>

        <label class="form-label">Birth date</label>
        <div class="third-block">

          <!-- DB col: day -->
          <div class="mb-3 day">
            <select class="form-select" id="day" name="day" required>
              <option selected disabled>Choose a day</option>
            </select>
          </div>

          <!-- DB col: month -->
          <div class="mb-3 month">
            <select class="form-select" id="month" name="month" required>
              <option selected disabled>Choose a month</option>
            </select>
          </div>

          <!-- DB col: year -->
          <div class="mb-3 year">
            <select class="form-select" id="year" name="year" required>
              <option selected disabled>Choose a year</option>
            </select>
          </div>

        </div>

        <div class="fourth-block">

          <!-- DB col: gender -->
          <div class="mb-3 address">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" class="form-control" name="gender" required>
              <option value="" disabled selected>--Select Gender--</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>

          <!-- DB col: address -->
          <div class="mb-3 address">
            <label for="address" class="form-label">Physical address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>

        </div>

        <!-- DB col: status (varchar 8) — active / inactive -->
        <div class="mb-3">
          <label for="status" class="form-label">Status</label>
          <select id="status" class="form-control" name="status" required>
            <option value="" disabled selected>--Select Status--</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
          </select>
        </div>

        <!-- DB col: joined_at (timestamp) — let the user pick or default to NOW() in PHP -->
        <div class="mb-3">
          <label for="joined_at" class="form-label">Date Joined</label>
          <input type="date" class="form-control" id="joined_at" name="joined_at"
                 value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <input type="submit" name="addMembers" class="btn submitBtn" value="Submit">
      </form>



        </div>
        <div class="tab-pane fade" id="editUpdate" role="tabpanel" aria-labelledby="tab2-tab">
             <h5></h5>
            <div class="container">
            <table id="membersTable"  style="background:none !important" class="table  table-striped table-bordered" >
            <thead>
                <tr>
                    <th>Mobile number</th>
                    <th>NIN</th>
                    <th>First name</th>
                    <th>Middle name</th>
                    <th>Last name</th>
                    <th>Birth date</th>
                    <th>Gender</th>
                    <th>Physical address</th>
                    <th>Status</th>
                    <th>Date Joined</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>

            <?php
require "connectDB.php";

$selectMembers = finance_db_query($connection, 'SELECT * FROM members');

if ($selectMembers === false) {
    global $finance_db_last_error;
    echo '<tr><td colspan="11" class="text-danger">Query error: ' . htmlspecialchars($finance_db_last_error ?? 'Unknown error') . '</td></tr>';
    return;
}

foreach ($selectMembers as $members) {

    $mobilenumber = $members['mobileNumber'] ?? $members['mobilenumber'] ?? '';
    $nin          = $members['nin']          ?? '';
    $fname        = $members['fname']        ?? '';
    $mname        = $members['mname']        ?? '';
    $lname        = $members['lname']        ?? '';
    $day          = $members['day']          ?? '';
    $month        = $members['month']        ?? '';
    $yearRaw      = $members['year']         ?? '';
    $gender       = $members['gender']       ?? '';
    $address      = $members['address']      ?? '';
    $status       = $members['status']       ?? '';
    $joined_at    = $members['joined_at']    ?? '';
    $email        = $members['email']        ?? '';

    // year is a timestamp — extract 4-digit year safely
    $yearDisplay = '';
    if (!empty($yearRaw)) {
        $dt = date_create($yearRaw);
        $yearDisplay = $dt ? date_format($dt, 'Y') : $yearRaw;
    }

    // joined_at — try date_create first, fallback to raw value so something always shows
    $joinedDisplay = '';
    if (!empty($joined_at)) {
        $dt = date_create($joined_at);
        $joinedDisplay = $dt ? date_format($dt, 'Y-m-d') : $joined_at;
    }

    echo "<tr class='dataRow'
               data-phone='"   . htmlspecialchars($mobilenumber) . "'
               data-nin='"     . htmlspecialchars($nin)          . "'
               data-fname='"   . htmlspecialchars($fname)        . "'
               data-mname='"   . htmlspecialchars($mname)        . "'
               data-lname='"   . htmlspecialchars($lname)        . "'
               data-day='"     . htmlspecialchars($day)          . "'
               data-month='"   . htmlspecialchars($month)        . "'
               data-year='"    . htmlspecialchars($yearDisplay)  . "'
               data-gender='"  . htmlspecialchars($gender)       . "'
               data-address='" . htmlspecialchars($address)      . "'
               data-status='"  . htmlspecialchars($status)       . "'
               data-joined='"  . htmlspecialchars($joinedDisplay). "'
               data-email='"   . htmlspecialchars($email)        . "'>";
    ?>
        <td><?php echo htmlspecialchars($mobilenumber); ?></td>
        <td><?php echo htmlspecialchars($nin);          ?></td>
        <td><?php echo htmlspecialchars($fname);        ?></td>
        <td><?php echo htmlspecialchars($mname);        ?></td>
        <td><?php echo htmlspecialchars($lname);        ?></td>
        <td><?php echo htmlspecialchars($day) . ' / ' . htmlspecialchars($month) . ' / ' . htmlspecialchars($yearDisplay); ?></td>
        <td><?php echo htmlspecialchars($gender);       ?></td>
        <td><?php echo htmlspecialchars($address);      ?></td>
  
        <td><?php echo htmlspecialchars($joinedDisplay); ?></td>
        <td class="email-cell" title="<?php echo htmlspecialchars($email); ?>">
            <?php echo htmlspecialchars($email); ?>
        </td>
    </tr>
    <?php
}
?>




            </tbody>
        </table>
        <style>
         .dt-paging{
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
<link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">



    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="assets/js/dashboards-analytics.js"></script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <!-- Dataset SCRIPTS -->
    <script>
      $('#myTable').dataTable( {
        layout: {
        topStart: {
            buttons: ['print']
        }
    },
        info:false,
      pagingType:"simple",
      "language": {
        "decimal":        "",
        "emptyTable":     "No data available in table",
        "info":         "",
        "infoFiltered":   "",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Show _MENU_ entries",
        "processing":     "",
        "search":         "Search:",
        "zeroRecords":    "No matching records found",
           "bProcessing": true,
        "sAutoWidth": false,
        "bDestroy":true,
        "sPaginationType": "bootstrap",
        "iDisplayStart ": 10,
        "iDisplayLength": 10,
        "bPaginate": false,
        "bFilter": false,
        "bInfo": false,
        "paginate": {
            "next":       "<button style='border:1px solid grey !important;color:grey;column-gap:0px'>Next</button>",
            "previous":   "<button style='border:1px solid grey !important;color:grey;column-gap:0px'>Previous</button>",
        }
      }

    } );

    // members table
    $('#membersTable').dataTable( {
      info:false,
      pagingType:"simple",
      "language": {
        "decimal":        "",
        "emptyTable":     "No data available in table",
        "info":" ",
        "infoFiltered":   "",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Show _MENU_ entries",
        "ordering":"",
        "processing":     "",
        "search":         "Search:",
        "zeroRecords":    "No matching records found",
        "paginate": {
            "next":       "<button  class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
            "previous":   "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>",
        }
      }
    } );

    </script>

    <!-- Get Years -->
<script>
    const startYear = 1950;
    const endYear = 2006;
    const yearSelect = document.getElementById('year');
    for (let year = startYear; year <= endYear; year++) {
        let option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
    }
</script>

<!-- Months -->
 <script>
    const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    const monthSelect = document.getElementById('month');
    months.forEach((month, index) => {
        let option = document.createElement('option');
        option.value = index + 1;
        option.textContent = month;
        monthSelect.appendChild(option);
    });
</script>

<!-- Generate Days -->
<script>
    const daySelect = document.getElementById('day');
    for (let day = 1; day <= 31; day++) {
        let option = document.createElement('option');
        option.value = day;
        option.textContent = day;
        daySelect.appendChild(option);
    }
</script>

       <!-- TABS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- NIN auto-dash script -->
    <script>
        $(document).ready(function() {
            $('#dash-input').on('input', function() {
                var input = $(this).val().replace(/-/g, '');
                var formatted = '';
                for (var i = 0; i < input.length; i++) {
                    if (i === 8 || i === 13 || i === 18) {
                        formatted += '-';
                    }
                    formatted += input[i];
                }
                $(this).val(formatted.slice(0, 23));
            });
        });
    </script>

<!-- Mobile number field script -->
<script>
        $(document).ready(function() {
            $('#mobilenumber').on('input', function() {
                var input = $(this).val().replace(/-/g, '');
                var formatted = '';
                for (var i = 0; i < input.length; i++) {
                    if (i === 3 || i === 6) {
                        formatted += '-';
                    }
                    formatted += input[i];
                }
                $(this).val(formatted.slice(0, 12));
            });
        });
    </script>

    <!-- Row selection / delete -->
    <script>
        $(document).ready(function() {
            let selectedId = null;

            $("tr").click(function() {
                $("tr").removeClass("selected");
                $(this).addClass("selected");
                selectedId = $(this).data("phone");
            });

            $("#delete-button").click(function() {
                if (selectedId === null) {
                    alert("Please select a record to delete.");
                    return;
                }
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = 'deleteMembers.php?id=' + selectedId;
                }
            });
        });
    </script>
  </body>
</html>