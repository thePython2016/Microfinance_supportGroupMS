<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
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
  <title>Shares</title>
  <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
  <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
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
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    input[type="text"], input[type="date"], input[type="number"], select {
      background-color: white !important;
    }
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
              <!-- Add Share button triggers modal -->
              <button type="button" class="btn addBtn" data-bs-toggle="modal" data-bs-target="#addShareModal">
                Add Share
              </button>
              <button class="btn addBtn ms-2" onclick="window.history.back()">
                <i class="fas fa-arrow-left"></i> Back
              </button>
            </div>
            <hr>

            <!-- Flash messages -->
            <?php if (isset($_SESSION['flash_success'])): ?>
              <div class="alert alert-success alert-dismissible fade show mx-3" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['flash_error'])): ?>
              <div class="alert alert-danger alert-dismissible fade show mx-3" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            <?php endif; ?>

            <!-- Shares Table -->
            <div class="col-12">
              <div class="card" style="margin-left:20px">
                <div class="card-header" style="color:rgb(61,60,60);font-size:16px;font-weight:bold">Shares</div>
                <div class="container">
                  <table id="membersTable" style="background:none !important" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>SN</th>
                        <th>Date</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $phone = $_GET['phone'] ?? '';
                      require "connectDB.php";

                      // Member info row
                      $selectMember = finance_db_query($connection,
                          "SELECT DISTINCT \"mobileNumber\", nin, fname, lname
                           FROM members
                           WHERE \"mobileNumber\" = '$phone'");

                      foreach ($selectMember ?: [] as $member): ?>
                        <tr>
                          <td colspan="3">
                            <strong><?php echo htmlspecialchars($member['mobileNumber'] ?? $member['mobilenumber'] ?? ''); ?></strong>
                            &nbsp;|&nbsp; <?php echo htmlspecialchars($member['nin'] ?? ''); ?>
                            &nbsp;|&nbsp; <?php echo htmlspecialchars($member['fname'] ?? ''); ?>
                            &nbsp;<?php echo htmlspecialchars($member['lname'] ?? ''); ?>
                          </td>
                        </tr>
                      <?php endforeach;

                      // Shares rows
                      $selectShares = finance_db_query($connection,
                          "SELECT \"shareID\", date, amount FROM shares WHERE member = '$phone'");

                      foreach ($selectShares ?: [] as $shares): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($shares['shareID'] ?? ''); ?></td>
                          <td><?php echo htmlspecialchars($shares['date']    ?? ''); ?></td>
                          <td><?php echo htmlspecialchars($shares['amount']  ?? ''); ?></td>
                        </tr>
                      <?php endforeach;

                      // Total row
                      $shareTotal = finance_db_query($connection,
                          "SELECT SUM(amount) AS totalShare FROM shares WHERE member = '$phone'");
                      $sumShares = 0;
                      foreach ($shareTotal ?: [] as $sum) {
                          $sumShares = $sum['totalShare'] ?? 0;
                      }
                      ?>
                      <tr>
                        <td style="font-weight:bold;font-size:15px">TOTAL</td>
                        <td></td>
                        <td style="font-weight:bold;font-size:15px"><?php echo htmlspecialchars((string)$sumShares); ?></td>
                      </tr>
                    </tbody>
                  </table>
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

<!-- ===== ADD SHARE MODAL ===== -->
<div class="modal fade" id="addShareModal" tabindex="-1" aria-labelledby="addShareModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addShareModalLabel">Add Share</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Form POSTs directly to sharesAdd.php -->
      <form method="POST" action="sharesAdd.php">
        <div class="modal-body">

          <!-- Member mobile number — pre-filled from URL param -->
          <div class="mb-3">
            <label for="memberField" class="form-label">Member (Mobile Number)</label>
            <input type="text" class="form-control" id="memberField" name="member"
                   value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
          </div>

          <!-- Date -->
          <div class="mb-3">
            <label for="dateField" class="form-label">Date</label>
            <input type="date" class="form-control" id="dateField" name="date"
                   value="<?php echo date('Y-m-d'); ?>" required>
          </div>

          <!-- Amount -->
          <div class="mb-3">
            <label for="amountField" class="form-label">Amount</label>
            <input type="number" class="form-control" id="amountField" name="amount"
                   min="1" step="0.01" placeholder="0.00" required>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <input type="submit" name="addShares" class="btn addBtn" value="Save Share">
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ===== END MODAL ===== -->

<!-- Core JS -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/js/menu.js"></script>
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/dashboards-analytics.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  $('#membersTable').dataTable({
    info: false,
    pagingType: "simple",
    language: {
      emptyTable: "No data available",
      search: "Search:",
      zeroRecords: "No matching records found",
      paginate: {
        next: "<button class='paging-button' style='border:1px solid grey;color:grey;margin:0'>Next</button>",
        previous: "<button class='paging-button' style='border:1px solid grey;color:grey'>Previous</button>"
      }
    }
  });
</script>
<style>.dt-paging { display:none !important; }</style>
</body>
</html>