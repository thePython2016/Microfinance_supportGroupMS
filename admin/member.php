<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username'])) {
  echo "<script>window.location.href='../index.php';</script>";
}
require "connectDB.php";

// Get mobile number from URL
$phone = isset($_GET['number']) ? trim($_GET['number']) : '';

if(empty($phone)) {
    echo "<script>alert('No mobile number provided.'); window.history.back();</script>";
    exit;
}

try {
    $query = "SELECT * FROM members 
              WHERE mobilenumber = :phone 
              OR mobilenumber = :phone_nodash 
              OR mobilenumber = :phone_nospace";

    $stmt = $connection->pdo->prepare($query);
    $stmt->execute([
        ':phone'         => $phone,
        ':phone_nodash'  => str_replace('-', '', $phone),
        ':phone_nospace' => str_replace(' ', '', $phone),
    ]);

    $selectMembers = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

    // Get total loans for this member
    $loanStmt = $connection->pdo->prepare(
        "SELECT 
            COUNT(*) as loan_count,
            SUM(amount) as total_amount,
            SUM(total_payable) as total_payable
         FROM loans 
         WHERE mobilenumber = :phone 
            OR mobilenumber = :phone_nodash 
            OR mobilenumber = :phone_nospace"
    );
    $loanStmt->execute([
        ':phone'         => $phone,
        ':phone_nodash'  => str_replace('-', '', $phone),
        ':phone_nospace' => str_replace(' ', '', $phone),
    ]);
    $loanTotals = $loanStmt->fetch(PDO::FETCH_ASSOC);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Member Details</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>

    <style>
      .hidden { display: none; }
      .dt-paging { display: none !important; }
      tr.selected { background-color: #d1ecf1 !important; }
    </style>
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
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center"></div>
              </div>
              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <?php require "user.php" ?>
              </ul>
            </div>
          </nav>
          <hr style="background:red !important;border:1px solid #00246B !important">

          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row gy-6">

                <!-- Action Buttons -->
                <div class="col-lg-12 col-md-12 col-12 mb-4">
                  <div class="d-flex justify-content-between w-100">
                    <button class="btn addBtn" onclick="goBack()">
                      <i class="fas fa-arrow-left"></i> Back
                    </button>
                    <button type="button" class="btn addBtn">Add Member</button>
                  </div>
                </div>
                <hr>

                <!-- Member Table Card -->
                <div class="col-12">
                  <div class="card" style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61,60,60);font-size:16px;font-weight:bold">
                      Member Details
                      <?php if(!empty($phone)): ?>
                        &mdash; <span style="font-weight:normal;font-size:14px;color:#555">Mobile: <?php echo htmlspecialchars($phone); ?></span>
                      <?php endif; ?>
                    </div>

                    <div class="container mt-3">
                      <div class="table-responsive">
                        <table id="membersTable" style="background:none !important" class="table table-striped table-bordered" style="width:100%">
                          <thead>
                            <tr>
                              <th>Mobile Number</th>
                              <th>NIN</th>
                              <th>First Name</th>
                              <th>Middle Name</th>
                              <th>Last Name</th>
                              <th>Gender</th>
                              <th>Birth Day</th>
                              <th>Birth Month</th>
                              <th>Birth Year</th>
                              <th>Physical Address</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php if(empty($selectMembers)): ?>
                              <tr>
                                <td colspan="10" class="text-center text-danger py-3">
                                  No member found for mobile number: <strong><?php echo htmlspecialchars($phone); ?></strong>
                                </td>
                              </tr>
                            <?php else: ?>
                              <?php foreach($selectMembers as $members): ?>
                              <tr class="dataRow"
                                  data-phone="<?php echo htmlspecialchars($members['mobilenumber']); ?>"
                                  data-nin="<?php echo htmlspecialchars($members['nin']); ?>"
                                  data-fname="<?php echo htmlspecialchars($members['fname']); ?>"
                                  data-mname="<?php echo htmlspecialchars($members['mname']); ?>"
                                  data-lname="<?php echo htmlspecialchars($members['lname']); ?>"
                                  data-gender="<?php echo htmlspecialchars($members['gender']); ?>"
                                  data-day="<?php echo htmlspecialchars($members['day']); ?>"
                                  data-month="<?php echo htmlspecialchars($members['month']); ?>"
                                  data-year="<?php echo htmlspecialchars($members['year']); ?>"
                                  data-address="<?php echo htmlspecialchars($members['address']); ?>">
                                <td><?php echo htmlspecialchars($members['mobilenumber']); ?></td>
                                <td><?php echo htmlspecialchars($members['nin']); ?></td>
                                <td><?php echo htmlspecialchars($members['fname']); ?></td>
                                <td><?php echo htmlspecialchars($members['mname']); ?></td>
                                <td><?php echo htmlspecialchars($members['lname']); ?></td>
                                <td><?php echo htmlspecialchars($members['gender']); ?></td>
                                <td><?php echo htmlspecialchars($members['day']); ?></td>
                                <td><?php echo htmlspecialchars($members['month']); ?></td>
                                <td><?php echo htmlspecialchars($members['year']); ?></td>
                                <td><?php echo htmlspecialchars($members['address']); ?></td>
                              </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </tbody>
                            <tfoot>
                              <tr style="background-color:#555 !important;color:#fff !important;font-weight:600;">
                                <td colspan="3" style="color:#fff !important;">
                                  Total Loans: <strong><?php echo (int)($loanTotals['loan_count'] ?? 0); ?></strong>
                                </td>
                                <td colspan="4" style="color:#fff !important;">
                                  Total Amount: <strong>TZS <?php echo number_format((float)($loanTotals['total_amount'] ?? 0), 2); ?></strong>
                                </td>
                                <td colspan="3" style="color:#fff !important;">
                                  Total Payable: <strong>TZS <?php echo number_format((float)($loanTotals['total_payable'] ?? 0), 2); ?></strong>
                                </td>
                              </tr>
                            </tfoot>
                          </table>
                      </div>
                    </div>

                    <!-- Action Buttons Row -->
                    <div class="container mb-3">
                      <div class="row">
                        <div class="col-12 d-flex gap-2">
                          <button type="button" id="showFormBtn" class="btn submitBtn hidden">Update Selected Row</button>
                          <button id="delete-button" type="button" class="btn submitBtn">Delete Selected</button>
                        </div>
                      </div>
                    </div>

                    <!-- Update Form -->
                    <div class="container mb-4">
                      <form id="editForm" class="hidden" method="POST" action="updateAll.php">
                        <h3 style="margin-top:20px">Update Record</h3>
                        <hr>
                        <div class="row">
                          <div class="col-md-6">

                            <!-- Hidden fields -->
                            <input type="hidden" name="phone" id="phone">
                            <input type="hidden" name="nin" id="nin">

                            <div class="mb-3">
                              <label class="form-label">First Name</label>
                              <input type="text" class="form-control" name="fname" id="fname">
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Middle Name</label>
                              <input type="text" class="form-control" name="mname" id="mname">
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Last Name</label>
                              <input type="text" class="form-control" name="lname" id="lname">
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Gender</label>
                              <input type="text" class="form-control" name="gender" id="gender" readonly>
                            </div>

                          </div>
                          <div class="col-md-6">

                            <div class="mb-3">
                              <label class="form-label">Birth Day</label>
                              <input type="text" class="form-control" name="day" id="day" readonly>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Birth Month</label>
                              <input type="text" class="form-control" name="month" id="month" readonly>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Birth Year</label>
                              <input type="text" class="form-control" name="year" id="year" readonly>
                            </div>
                            <div class="mb-3">
                              <label class="form-label">Address</label>
                              <input type="text" class="form-control" name="address" id="address">
                            </div>

                          </div>
                        </div>

                        <button type="submit" name="updateMembers" class="btn submitBtn mb-3">Update</button>
                      </form>
                    </div>

                  </div>
                </div>
                <!-- / Card -->

              </div>
            </div>

            <!-- Footer -->
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
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

    <script src="assets/js/main.js"></script>
    <script src="assets/js/dashboards-analytics.js"></script>

    <script>
      // Init DataTable
      $(document).ready(function() {
        $('#membersTable').DataTable({
          info: false,
          pagingType: "simple",
          language: {
            emptyTable: "No data available in table",
            search: "Search:",
            zeroRecords: "No matching records found",
            paginate: {
              next: "<button class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
              previous: "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>"
            }
          }
        });
      });
    </script>

    <script>
      // Delete selected row
      $(document).ready(function() {
        let selectedId = null;

        $("tr.dataRow").click(function() {
          $("tr").removeClass("selected");
          $(this).addClass("selected");
          selectedId = $(this).data("phone");
        });

        $("#delete-button").click(function() {
          if (!selectedId) {
            alert("Please select a record to delete.");
            return;
          }
          if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = 'deleteMembers.php?id=' + selectedId;
          }
        });
      });
    </script>

    <script>
      // Update form population
      document.addEventListener('DOMContentLoaded', () => {
        const table      = document.getElementById('membersTable');
        const showFormBtn = document.getElementById('showFormBtn');
        const form       = document.getElementById('editForm');

        const phone   = document.getElementById('phone');
        const nin     = document.getElementById('nin');
        const fname   = document.getElementById('fname');
        const mname   = document.getElementById('mname');
        const lname   = document.getElementById('lname');
        const day     = document.getElementById('day');
        const month   = document.getElementById('month');
        const year    = document.getElementById('year');
        const gender  = document.getElementById('gender');
        const address = document.getElementById('address');

        let selectedRow = null;

        // Click on table row — populate form fields
        table.addEventListener('click', (e) => {
          const row = e.target.closest('tr.dataRow');
          if (!row) return;

          document.querySelectorAll('tr').forEach(r => r.classList.remove('selected'));
          row.classList.add('selected');

          const cells = Array.from(row.children);
          phone.value   = cells[0].innerText.trim();
          nin.value     = cells[1].innerText.trim();
          fname.value   = cells[2].innerText.trim();
          mname.value   = cells[3].innerText.trim();
          lname.value   = cells[4].innerText.trim();
          gender.value  = cells[5].innerText.trim();
          day.value     = cells[6].innerText.trim();
          month.value   = cells[7].innerText.trim();
          year.value    = cells[8].innerText.trim();
          address.value = cells[9].innerText.trim();

          selectedRow = row;
          showFormBtn.classList.remove('hidden');
        });

        // Show update form
        showFormBtn.addEventListener('click', () => {
          if (selectedRow) {
            form.classList.remove('hidden');
            form.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    </script>

    <script>
      function goBack() { window.history.back(); }
    </script>

  </body>
</html>