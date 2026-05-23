<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
?><!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr"
  data-theme="theme-default" data-assets-path="../assets/"
  data-template="vertical-menu-template-free" data-style="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Financial Officers</title>
  <meta name="description" content="" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Datatables -->
  <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Theme assets -->
  <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />
  <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="assets/css/demo.css" />
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>

  <!-- Helpers & config (no output) -->
  <script src="assets/vendor/js/helpers.js"></script>
  <script src="assets/js/config.js"></script>

  <!-- jQuery first (DataTables depends on it) -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <?php require "menu.php"; ?>

      <div class="layout-page">
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
              <i class="ri-menu-fill ri-24px"></i>
            </a>
          </div>
          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <?php require "user.php"; ?>
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
                  <div class="card-header" style="color:rgb(61,60,60)!important;font-size:16px;font-weight:bold">
                    Financial Officers Form
                  </div>

                  <div class="container mt-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#officersForm" role="tab" aria-selected="true">Officers</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab2-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-selected="false">Officers List</a>
                      </li>
                    </ul>

                    <div class="tab-content mb-5 tabForms" id="myTabContent">

                      <!-- ===== OFFICERS FORM TAB ===== -->
                      <div class="tab-pane fade show active" id="officersForm" role="tabpanel">

                        <style>
                          input[type="text"] { background-color: white !important; }
                          select { background-color: white; }
                        </style>

                        <!-- Flash messages at top of form -->
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

                          <!-- Block 1: Contact & Identity -->
                          <div class="first-block">
                            <div class="mb-3 mobile">
                              <label for="mobile-number" class="form-label">Mobile number</label>
                              <input type="text" id="mobile-number" name="phone" class="form-control" maxlength="12" placeholder="076-123-7891" required>
                            </div>
                            <div class="mb-3 nin">
                              <label for="dash-input" class="form-label">NIN</label>
                              <input type="text" id="dash-input" name="nin" class="form-control" maxlength="23" placeholder="12345678-12345-12345-09" required>
                            </div>
                            <div class="mb-3">
                              <label for="occupation" class="form-label">Occupation</label>
                              <input type="text" class="form-control" id="occupation" name="occupation">
                            </div>
                          </div>

                          <!-- Block 2: Names -->
                          <div class="second-block">
                            <div class="mb-3 fname">
                              <label for="fname" class="form-label">First name</label>
                              <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="mb-3 mname">
                              <label for="mname" class="form-label">Middle name</label>
                              <input type="text" class="form-control" id="mname" name="mname" required>
                            </div>
                            <div class="mb-3 lname">
                              <label for="lname" class="form-label">Last name</label>
                              <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                          </div>

                          <!-- Block 3: Birth date -->
                          <label class="form-label">Birth date</label>
                          <div class="third-block">
                            <div class="mb-3 day">
                              <select class="form-select" id="day" name="day" required>
                                <option selected disabled>Choose a day</option>
                              </select>
                            </div>
                            <div class="mb-3 month">
                              <select class="form-select" id="month" name="month" required>
                                <option selected disabled>Choose a month</option>
                              </select>
                            </div>
                            <div class="mb-3 year">
                              <select class="form-select" id="year" name="year" required>
                                <option selected disabled>Choose a year</option>
                              </select>
                            </div>
                          </div>

                          <!-- Block 4: Gender, Address -->
                          <div class="fourth-block">
                            <div class="mb-3 address">
                              <label for="gender" class="form-label">Gender</label>
                              <select id="gender" class="form-control" name="gender" required>
                                <option value="" disabled selected>--Select Gender--</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                              </select>
                            </div>
                            <div class="mb-3 address">
                              <label for="address" class="form-label">Physical address</label>
                              <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                          </div>

                          <button type="submit" name="addOfficers" class="btn submitBtn">Submit</button>
                        </form>

                      </div>
                      <!-- ===== END OFFICERS FORM TAB ===== -->

                      <!-- ===== OFFICERS LIST TAB ===== -->
                      <div class="tab-pane fade" id="editUpdate" role="tabpanel">
                        <div class="container">
                          <style>.dt-paging { display:none !important; }</style>
                          <table id="officersTable" style="background:none !important" class="table table-striped table-bordered">
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
                                <th>Occupation</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              require "connectDB.php";
                              $selectOfficers = finance_db_query($connection, "SELECT * FROM officers");
                              foreach ($selectOfficers ?: [] as $officer):
                                  $mob        = htmlspecialchars($officer['mobileNumber'] ?? '');
                                  $nin        = htmlspecialchars($officer['nin']          ?? '');
                                  $fname      = htmlspecialchars($officer['fname']        ?? '');
                                  $mname      = htmlspecialchars($officer['mname']        ?? '');
                                  $lname      = htmlspecialchars($officer['lname']        ?? '');
                                  $gender     = htmlspecialchars($officer['gender']       ?? '');
                                  $day        = htmlspecialchars($officer['day']          ?? '');
                                  $month      = htmlspecialchars($officer['month']        ?? '');
                                  $year       = htmlspecialchars($officer['year']         ?? '');
                                  $address    = htmlspecialchars($officer['address']      ?? '');
                                  $occupation = htmlspecialchars($officer['occupation']   ?? '');
                              ?>
                                <tr class="dataRow"
                                    data-phone="<?php echo $mob; ?>"
                                    data-nin="<?php echo $nin; ?>"
                                    data-fname="<?php echo $fname; ?>"
                                    data-mname="<?php echo $mname; ?>"
                                    data-lname="<?php echo $lname; ?>"
                                    data-gender="<?php echo $gender; ?>"
                                    data-day="<?php echo $day; ?>"
                                    data-month="<?php echo $month; ?>"
                                    data-year="<?php echo $year; ?>"
                                    data-address="<?php echo $address; ?>"
                                    data-occupation="<?php echo $occupation; ?>">
                                  <td><?php echo $mob; ?></td>
                                  <td><?php echo $nin; ?></td>
                                  <td><?php echo $fname; ?></td>
                                  <td><?php echo $mname; ?></td>
                                  <td><?php echo $lname; ?></td>
                                  <td><?php echo $gender; ?></td>
                                  <td><?php echo $day . ' / ' . $month . ' / ' . $year; ?></td>
                                  <td><?php echo $address; ?></td>
                                  <td><?php echo $occupation; ?></td>
                                </tr>
                              <?php endforeach; ?>
                            </tbody>
                          </table>

                          <button id="delete-button" class="btn btn-danger mt-3">Delete Selected</button>
                        </div>
                      </div>
                      <!-- ===== END OFFICERS LIST TAB ===== -->

                    </div><!-- end tab-content -->
                  </div><!-- end container mt-4 -->

                </div><!-- end card -->
              </div><!-- end col-12 -->

            </div>
          </div>

          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
              <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                <div class="text-body mb-2 mb-md-0">
                  MFSGMS &copy; <script>document.write(new Date().getFullYear());</script> All Rights Reserved
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
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="assets/js/main.js"></script>
  <script src="assets/js/dashboards-analytics.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

  <!-- Bootstrap Bundle (tabs + alerts) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- DataTable init -->
  <script>
    $('#officersTable').dataTable({
      info: false,
      pagingType: "simple",
      language: {
        emptyTable:  "No data available in table",
        search:      "Search:",
        zeroRecords: "No matching records found",
        paginate: {
          next:     "<button class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
          previous: "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>"
        }
      }
    });
  </script>

  <!-- Populate day / month / year dropdowns -->
  <script>
    const daySelect = document.getElementById('day');
    for (let d = 1; d <= 31; d++) {
      let o = document.createElement('option'); o.value = d; o.textContent = d; daySelect.appendChild(o);
    }

    const monthNames = ["January","February","March","April","May","June",
                        "July","August","September","October","November","December"];
    const monthSelect = document.getElementById('month');
    monthNames.forEach((m, i) => {
      let o = document.createElement('option'); o.value = i + 1; o.textContent = m; monthSelect.appendChild(o);
    });

    const yearSelect = document.getElementById('year');
    for (let y = 1950; y <= 2006; y++) {
      let o = document.createElement('option'); o.value = y; o.textContent = y; yearSelect.appendChild(o);
    }
  </script>

  <!-- NIN & mobile formatting -->
  <script>
    $(document).ready(function () {

      $('#dash-input').on('input', function () {
        var raw = $(this).val().replace(/-/g, ''), fmt = '';
        for (var i = 0; i < raw.length; i++) {
          if (i === 8 || i === 13 || i === 18) fmt += '-';
          fmt += raw[i];
        }
        $(this).val(fmt.slice(0, 23));
      });

      $('#mobile-number').on('input', function () {
        var raw = $(this).val().replace(/-/g, ''), fmt = '';
        for (var i = 0; i < raw.length; i++) {
          if (i === 3 || i === 6) fmt += '-';
          fmt += raw[i];
        }
        $(this).val(fmt.slice(0, 12));
      });

      // Row select & delete
      let selectedId = null;
      $('tr').click(function () {
        $('tr').removeClass('selected');
        $(this).addClass('selected');
        selectedId = $(this).data('phone');
      });

      $('#delete-button').click(function () {
        if (!selectedId) { alert('Please select a record to delete.'); return; }
        if (confirm('Are you sure you want to delete this record?')) {
          window.location.href = 'deleteOfficers.php?id=' + selectedId;
        }
      });

    });
  </script>

</body>
</html>