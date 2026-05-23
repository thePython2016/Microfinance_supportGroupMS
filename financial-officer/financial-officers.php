<?php
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

if (!isset($_SESSION['username'])) {
    echo "<script>window.location.href='../index.php';</script>";
    exit;
}
?>
<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr"
  data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free" data-style="light">
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Financial Officers</title>
  <meta name="description" content="" />

  <!-- Datatable Top begin-->
  <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />
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

  <!-- Helpers -->
  <script src="assets/vendor/js/helpers.js"></script>
  <script src="assets/js/config.js"></script>

  <!-- Charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      
      <?php require "menu.php" ?>

      <div class="layout-page">
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="ri-menu-fill ri-24px"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <?php require "user.php" ?>
            </ul>
          </div>
        </nav>
        <hr style="background:red !important;border:1px solid #00246B !important">

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row gy-6">

              <div class="col-lg-12 col-md-12 col-12 mb-4">
                <a class="btn addBtn" href="financial-officers.php">Add Financial Officer</a>
              </div>
              <hr>

              <div class="col-12">
                <div class="card" style="margin-left:20px">
                  <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Financial Officers Form</div>

                  <div class="container mt-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-selected="true">Officers</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-selected="false">Officers List</a>
                      </li>
                    </ul>

                    <div class="tab-content tabForms" id="myTabContent">
                      <div class="tab-pane fade show active" id="membersForm" role="tabpanel">

                        <!-- Flash Messages -->
                        <?php if (isset($_SESSION['flash_success'])): ?>
                          <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['flash_error'])): ?>
                          <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                          </div>
                        <?php endif; ?>

                        <form method="POST" action="officersAdd.php">
                          <div class="first-block">
                            <div class="mb-3 mobile">
                              <label class="form-label">Mobile number</label>
                              <input type="text" id="mobile-number" name="phone" class="form-control" maxlength="12" placeholder="076-123-7891" required>
                            </div>
                            <div class="mb-3 nin">
                              <label class="form-label">NIN</label>
                              <input type="text" id="dash-input" name="nin" class="form-control" maxlength="23" placeholder="12345678-12345-12345-09" required>
                            </div>
                            <div class="mb-3 occupation">
                              <label class="form-label">Occupation</label>
                              <input type="text" class="form-control" id="ninField">
                            </div>
                          </div>

                          <style>
                            input[type="text"] { background-color: white !important; }
                            select { background-color: white; }
                          </style>

                          <div class="second-block">
                            <div class="mb-3 fname">
                              <label class="form-label">First name</label>
                              <input type="text" class="form-control" id="fname" name="fname">
                            </div>
                            <div class="mb-3 mname">
                              <label class="form-label">Middle name</label>
                              <input type="text" class="form-control" id="mname" name="mname">
                            </div>
                            <div class="mb-3 lname">
                              <label class="form-label">Last name</label>
                              <input type="text" class="form-control" id="lname" name="lname">
                            </div>
                          </div>

                          <label class="form-label">Birth date</label>
                          <div class="third-block">
                            <div class="mb-3 day">
                              <select class="form-select" id="day" name="day">
                                <option selected disabled>Choose a day</option>
                              </select>
                            </div>
                            <div class="mb-3 month">
                              <select class="form-select" id="month" name="month">
                                <option selected disabled>Choose a month</option>
                              </select>
                            </div>
                            <div class="mb-3 year">
                              <select class="form-select" id="year" name="year">
                                <option>Choose a year</option>
                              </select>
                            </div>
                          </div>

                          <div class="fourth-block">
                            <div class="mb-3 address">
                              <label class="form-label">Gender</label>
                              <select id="gender" class="form-control" name="gender" required>
                                <option value="">--Select Gender--</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                              </select>
                            </div>
                            <div class="mb-3 address">
                              <label class="form-label">Physical address</label>
                              <input type="text" class="form-control" id="address" name="address">
                            </div>
                          </div>

                          <button type="submit" name="addOfficers" class="btn submitBtn">Submit</button>
                        </form>
                      </div>

                      <div class="tab-pane fade" id="editUpdate" role="tabpanel">
                        <h5>Officers List</h5>
                        <div>
                          <style>
                            .dt-paging { display:none !important; }
                          </style>
                          <table id="officersTable" style="background:none !important" class="table table-striped table-bordered">
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
                              <style>
                                .hidden { display: none; }
                              </style>
                              <?php
                              require "connectDB.php";
                              $selectMembers = finance_db_query($connection, "SELECT * FROM officers");
                              
                              foreach ($selectMembers ?: [] as $members):
                                  $mob = htmlspecialchars($members['mobileNumber'] ?? $members['mobilenumber'] ?? '');
                                  $nin = htmlspecialchars($members['nin'] ?? '');
                                  $fname = htmlspecialchars($members['fname'] ?? '');
                                  $mname = htmlspecialchars($members['mname'] ?? '');
                                  $lname = htmlspecialchars($members['lname'] ?? '');
                                  $gender = htmlspecialchars($members['gender'] ?? '');
                                  $day = htmlspecialchars($members['day'] ?? '');
                                  $month = htmlspecialchars($members['month'] ?? '');
                                  $year = htmlspecialchars($members['year'] ?? '');
                                  $address = htmlspecialchars($members['address'] ?? '');
                              ?>
                                <tr class='dataRow' 
                                    data-phone="<?php echo $mob; ?>" 
                                    data-nin="<?php echo $nin; ?>"
                                    data-fname="<?php echo $fname; ?>" 
                                    data-mname="<?php echo $mname; ?>"
                                    data-lname="<?php echo $lname; ?>" 
                                    data-day="<?php echo $day; ?>" 
                                    data-month="<?php echo $month; ?>"
                                    data-year="<?php echo $year; ?>" 
                                    data-gender="<?php echo $gender; ?>" 
                                    data-address="<?php echo $address; ?>">
                                  <td><?php echo $mob; ?></td>
                                  <td><?php echo $nin; ?></td>
                                  <td><?php echo $fname; ?></td>
                                  <td><?php echo $mname; ?></td>
                                  <td><?php echo $lname; ?></td>
                                  <td><?php echo $gender; ?></td>
                                  <td><?php echo $day; ?></td>
                                  <td><?php echo $month; ?></td>
                                  <td><?php echo $year; ?></td>
                                  <td><?php echo $address; ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <div class="tab-pane fade" id="uploadForm" role="tabpanel">
                        <h5>Upload Data</h5>
                        <input type="file" class="form-control" id="uploadField">
                        <button type="submit" name="submit" class="btn btn-primary uploadBtn mt-2">Upload</button>
                      </div>

                      <div class="tab-pane fade" id="uploadSample" role="tabpanel">
                        <a href="uploadedSampleFiles/payments.csv" class="payment-sample" download="payments.csv">Payments Sample file</a> <br>
                        <a href="uploadedSampleFiles/staff.csv" class="staff-sample" download="staff.csv">Staff Sample file</a> <br>
                        <a href="uploadedSampleFiles/student data.csv" class="student-sample" download="student data.csv">Student Sample file</a>
                      </div>
                    </div>

                  </div>
                </div>
              </div>

            </div>
          </div>

          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                <div class="text-body mb-2 mb-md-0">
                  MFSGMS © <script>document.write(new Date().getFullYear());</script> All Rights Reserved
                </div>
              </div>
            </div>
          </footer>
          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <!-- Core JS -->
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="assets/vendor/js/menu.js"></script>

  <!-- Vendors JS -->
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
  
  <!-- Datatables bottom -->
  <link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
  <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">

  <!-- Main JS -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/dashboards-analytics.js"></script>

  <script>
    $('#officersTable').dataTable({
      info: false,
      pagingType: "simple",
      language: {
        decimal: "",
        emptyTable: "No data available in table",
        info: " ",
        infoFiltered: "",
        infoPostFix: "",
        thousands: ",",
        lengthMenu: "Show _MENU_ entries",
        ordering: "",
        processing: "",
        search: "Search:",
        zeroRecords: "No matching records found",
        paginate: {
          next: "<button class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
          previous: "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>",
        }
      }
    });
  </script>

  <!-- Dynamic Date Populators -->
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

    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    const monthSelect = document.getElementById('month');
    months.forEach((month, index) => {
        let option = document.createElement('option');
        option.value = index + 1;
        option.textContent = month;
        monthSelect.appendChild(option);
    });

    const daySelect = document.getElementById('day');
    for (let day = 1; day <= 31; day++) {
        let option = document.createElement('option');
        option.value = day;
        option.textContent = day;
        daySelect.appendChild(option);
    }
  </script>

  <!-- Input Formatting Scripts -->
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

        $('#mobile-number').on('input', function() {
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>