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
              <a class="btn addBtn" href="shares.php">Add Share</a>
            </div>
            <hr>

            <div class="col-12">
              <div class="card" style="margin-left:20px">
                <div class="card-header" style="color:rgb(61,60,60);font-size:16px;font-weight:bold">Shares Form</div>

                <div class="container mt-4">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-selected="true">Shares</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-selected="false">Shares List</a>
                    </li>
                  </ul>

                  <div class="tab-content mb-5 tabForms" id="myTabContent">

                    <!-- ADD SHARE FORM TAB -->
                    <div class="tab-pane fade show active" id="membersForm" role="tabpanel">

                      <!-- Flash messages -->
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

                      <form action="shareAdd.php" method="POST">
                        <div class="first-block">

                          <!-- Date -->
                          <div class="mb-3 nin">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="date"
                                   value="<?php echo date('Y-m-d'); ?>" required>
                          </div>

                          <!-- Member dropdown -->
                          <div class="mb-3 mobile">
                            <label class="form-label">Member</label>
                            <select class="form-control" name="member_id" required>
                              <option value="" disabled selected>--Select Member--</option>
                              <?php
                              require "connectDB.php";
                              
                              // Explicitly naming columns so we know their direct positions
                              $selectMembers = finance_db_query($connection, "SELECT id, fname, lname, mobilenumber FROM members ORDER BY fname");
                              
                              foreach ($selectMembers ?: [] as $m):
                                  // Read by key name if available, fallback to index positions if keys are transformed to uppercase/lowercase by the driver
                                  $memberId = htmlspecialchars((string)($m['id'] ?? $m['ID'] ?? array_values($m)[0] ?? ''));
                                  $firstName = htmlspecialchars((string)($m['fname'] ?? $m['FNAME'] ?? array_values($m)[1] ?? ''));
                                  $lastName  = htmlspecialchars((string)($m['lname'] ?? $m['LNAME'] ?? array_values($m)[2] ?? ''));
                                  $mob       = htmlspecialchars(trim((string)($m['mobileNumber'] ?? $m['mobilenumber'] ?? $m['MOBILENUMBER'] ?? array_values($m)[3] ?? '')));
                                  
                                  $name = trim($firstName . ' ' . $lastName);
                                  if (!empty($memberId)):
                              ?>
                                <option value="<?php echo $memberId; ?>"><?php echo $mob . ' — ' . $name; ?></option>
                              <?php 
                                  endif;
                              endforeach; 
                              ?>
                            </select>
                          </div>

                        </div>

                        <div class="second-block">
                          <!-- Amount -->
                          <div class="mb-3 fname">
                            <label class="form-label">Amount</label>
                            <input type="number" class="form-control" name="amount"
                                   min="1" step="0.01" placeholder="0.00" required>
                          </div>
                        </div>

                        <button type="submit" class="btn submitBtn" name="addShares">Submit</button>
                      </form>

                    </div>

                    <!-- SHARES LIST TAB -->
                    <div class="tab-pane fade" id="editUpdate" role="tabpanel">
                      <div class="container">
                        <table id="sharesTable" class="table table-striped table-bordered">
                          <thead>
                            <tr>
                              <th>SN</th>
                              <th>Date</th>
                              <th>Member</th>
                              <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $selectShares = finance_db_query($connection,
                                "SELECT s.id, s.share_date, s.amount,
                                        m.fname, m.lname, m.id AS member_id,
                                        m.mobilenumber, m.\"mobileNumber\"
                                 FROM shares s
                                 JOIN members m ON m.id = s.member_id
                                 ORDER BY s.share_date DESC");

                            $sn = 1;
                            foreach ($selectShares ?: [] as $share):
                                $mob = htmlspecialchars($share['mobileNumber'] ?? $share['mobilenumber'] ?? $share['MOBILENUMBER'] ?? '');
                                $fullName = htmlspecialchars(trim(($share['fname'] ?? $share['FNAME'] ?? '') . ' ' . ($share['lname'] ?? $share['LNAME'] ?? '')));
                            ?>
                              <tr>
                                <td><?php echo $sn++; ?></td>
                                <td><?php echo htmlspecialchars($share['share_date'] ?? $share['SHARE_DATE'] ?? ''); ?></td>
                                <td>
                                  <a class="url" href="shares.php?member_id=<?php echo (int)($share['member_id'] ?? $share['MEMBER_ID'] ?? 0); ?>">
                                    <?php echo $mob . ' — ' . $fullName; ?>
                                  </a>
                                </td>
                                <td><?php echo htmlspecialchars($share['amount'] ?? $share['AMOUNT'] ?? ''); ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                        <style>.dt-layout-end { display:none !important; }</style>
                      </div>
                    </div>

                  </div><!-- end tab-content -->
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
  $('#sharesTable').dataTable({
    info: false,
    pagingType: "simple",
    language: {
      emptyTable: "No data available in table",
      search: "Search:",
      zeroRecords: "No matching records found",
      paginate: {
        next: "<button class='paging-button' style='border:1px solid grey;color:grey;margin:0'>Next</button>",
        previous: "<button class='paging-button' style='border:1px solid grey;color:grey'>Previous</button>"
      }
    }
  });
</script>
</body>
</html>