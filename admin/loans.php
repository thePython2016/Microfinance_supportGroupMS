<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username'])) {
  echo "<script>window.location.href='../index.php';</script>";
}
require "connectDB.php";

try {
    $query = "SELECT m.mobilenumber, m.fname, m.lname, 
                     l.id, l.loan_date, l.due_date, l.amount, l.interest_rate, l.total_payable, l.status, l.notes
              FROM members m 
              INNER JOIN loans l ON m.mobilenumber = l.mobilenumber
              ORDER BY m.mobilenumber, l.loan_date DESC";
    $result = $connection->pdo->query($query);
    if (!$result) { echo "Query failed"; die(); }
    $loanrecord = $result->fetchAll(PDO::FETCH_ASSOC) ?: [];

    $totalQuery = "SELECT l.mobilenumber, m.fname, m.lname,
                          COUNT(*) as loan_count,
                          SUM(l.amount) as total_amount,
                          SUM(l.total_payable) as total_payable
                   FROM loans l
                   INNER JOIN members m ON m.mobilenumber = l.mobilenumber
                   GROUP BY l.mobilenumber, m.fname, m.lname";
    $totalResult = $connection->pdo->query($totalQuery);
    $totalsMap   = [];
    foreach($totalResult->fetchAll(PDO::FETCH_ASSOC) as $t) {
        $totalsMap[$t['mobilenumber']] = $t;
    }

    $selectMember = finance_db_query($connection, "SELECT * FROM members ORDER BY fname ASC");

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    die();
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
  <title>Loans</title>

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

              <div class="col-lg-12 col-md-12 col-12 mb-4">
                <a class="btn addBtn" href="loans.php">Add Loan</a>
              </div>
              <hr>

              <div class="col-12">
                <div class="card" style="margin-left:20px">
                  <div class="card-header" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">
                    Member's Loan
                  </div>

                  <div class="container mt-4">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-selected="true">Add Loan</a>
                      </li>
                      <li class="nav-item" role="presentation">
                        <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-selected="false">Loans List</a>
                      </li>
                    </ul>

                    <div class="tab-content tabForms" id="myTabContent">

                      <!-- ADD LOAN TAB -->
                      <div class="tab-pane fade show active" id="membersForm" role="tabpanel">

                        <style>
                          input[type="text"]   { background-color: white !important; }
                          input[type="number"] { background-color: white !important; }
                          input[type="date"]   { background-color: white !important; }
                          select { background-color: white; }
                        </style>

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

                        <form method="POST" action="loanAdd.php">
                          <div class="first-block">

                            <div class="mb-3 nin">
                              <label for="loan_date" class="form-label">Loan Date</label>
                              <input type="date" class="form-control" name="loan_date" id="loan_date" required>
                            </div>

                            <div class="mb-3 nin">
                              <label for="due_date" class="form-label">Due Date</label>
                              <input type="date" class="form-control" name="due_date" id="due_date" required>
                            </div>

                            <div class="mb-3 mobile">
                              <label for="member" class="form-label">Member</label>
                              <select id="member" class="form-control" name="member_id" required>
                                <option value="" disabled selected>--Select Member--</option>
                                <?php foreach($selectMember ?: [] as $member) { ?>
                                <option value="<?php echo htmlspecialchars($member['mobileNumber'])?>">
                                  <?php echo htmlspecialchars($member['mobileNumber'].' - '.$member['fname'].' '.$member['lname'])?>
                                </option>
                                <?php } ?>
                              </select>
                            </div>

                          </div>

                          <div class="second-block">

                            <div class="mb-3 fname">
                              <label for="amount" class="form-label">Amount (TZS)</label>
                              <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                            </div>

                            <div class="mb-3 fname">
                              <label for="interest_rate" class="form-label">Interest Rate (%)</label>
                              <input type="number" class="form-control" id="interest_rate" name="interest_rate" min="0" max="100" step="0.01" required>
                            </div>

                            <div class="mb-3 fname">
                              <label for="total_payable" class="form-label">Total Payable (TZS)</label>
                              <input type="number" class="form-control" id="total_payable" name="total_payable" placeholder="Auto-calculated" readonly style="background-color:#f8f9fa !important;">
                            </div>

                            <div class="mb-3 fname">
                              <label for="status" class="form-label">Status</label>
                              <select id="status" class="form-control" name="status" required>
                                <option value="" disabled selected>--Select Status--</option>
                                <option value="active">Active</option>
                                <option value="pending">Pending</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                              </select>
                            </div>

                          </div>

                          <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                              placeholder="Additional notes..."
                              style="background-color:white !important;resize:vertical"></textarea>
                          </div>

                          <button type="submit" name="addLoan" class="btn submitBtn">Submit</button>
                        </form>
                      </div>
                      <!-- END ADD LOAN TAB -->

                      <style>
                        .hidden { display: none; }
                        .dt-paging { display:none !important; }
                      </style>

                      <!-- LOANS LIST TAB -->
                      <div class="tab-pane fade" id="editUpdate" role="tabpanel">
                        <div class="container mt-3">
                          <div class="table-responsive">
                            <table id="membersTable" class="table mb-5 table-striped table-bordered" style="width:100%">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Mobile Number</th>
                                  <th>Member Name</th>
                                  <th>Loan Date</th>
                                  <th>Due Date</th>
                                  <th>Amount (TZS)</th>
                                  <th>Interest Rate</th>
                                  <th>Total Payable (TZS)</th>
                                  <th>Status</th>
                                  <th>Notes</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $i = 1;
                                foreach($loanrecord as $loan):
                                  $status = $loan['status'] ?? 'unknown';
                                  $badge = match($status) {
                                    'active'  => 'success',
                                    'pending' => 'warning',
                                    'paid'    => 'info',
                                    'overdue' => 'danger',
                                    default   => 'secondary'
                                  };
                                  $member_name = trim(($loan['fname'] ?? '') . ' ' . ($loan['lname'] ?? '')) ?: '-';
                                ?>
                                <tr>
                                  <td><?php echo $i++; ?></td>
                                  <td>
                                    <a class="url" href="member.php?number=<?php echo urlencode($loan['mobilenumber']); ?>">
                                      <?php echo htmlspecialchars($loan['mobilenumber']); ?>
                                    </a>
                                  </td>
                                  <td><?php echo htmlspecialchars($member_name); ?></td>
                                  <td><?php echo htmlspecialchars($loan['loan_date'] ?? '-'); ?></td>
                                  <td><?php echo htmlspecialchars($loan['due_date'] ?? '-'); ?></td>
                                  <td><?php echo number_format((float)($loan['amount'] ?? 0), 2); ?></td>
                                  <td><?php echo htmlspecialchars($loan['interest_rate'] ?? '0'); ?>%</td>
                                  <td><?php echo number_format((float)($loan['total_payable'] ?? 0), 2); ?></td>
                                  <td>
                                    <span class="badge bg-<?php echo $badge; ?>">
                                      <?php echo ucfirst($status); ?>
                                    </span>
                                  </td>
                                  <td><?php echo htmlspecialchars($loan['notes'] ?: '-'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                              </tbody>

                              <tfoot>
                                <?php foreach($totalsMap as $mobile => $t): ?>
                                <tr style="background-color:#555 !important;color:#fff !important;font-weight:600;">
                                  <td colspan="2" style="color:#fff !important;">
                                    <a href="member.php?number=<?php echo urlencode($mobile); ?>" style="color:#fff;font-weight:700;">
                                      <?php echo htmlspecialchars($mobile); ?>
                                    </a>
                                  </td>
                                  <td style="color:#fff !important;"><?php echo htmlspecialchars(trim($t['fname'].' '.$t['lname'])); ?></td>
                                  <td colspan="2" style="color:#fff !important;">Loans: <strong><?php echo (int)$t['loan_count']; ?></strong></td>
                                  <td style="color:#fff !important;"><strong>TZS <?php echo number_format((float)$t['total_amount'], 2); ?></strong></td>
                                  <td style="color:#fff !important;"></td>
                                  <td style="color:#fff !important;"><strong>TZS <?php echo number_format((float)$t['total_payable'], 2); ?></strong></td>
                                  <td colspan="2" style="color:#fff !important;"></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr style="background-color:#333 !important;color:#fff !important;font-weight:700;font-size:15px;">
                                  <td colspan="5" style="color:#fff !important;text-align:right;padding-right:10px;">Grand Total (All Members):</td>
                                  <td style="color:#fff !important;">TZS <?php echo number_format(array_sum(array_column($totalsMap, 'total_amount')), 2); ?></td>
                                  <td style="color:#fff !important;"></td>
                                  <td style="color:#fff !important;">TZS <?php echo number_format(array_sum(array_column($totalsMap, 'total_payable')), 2); ?></td>
                                  <td colspan="2" style="color:#fff !important;"></td>
                                </tr>
                              </tfoot>

                            </table>
                          </div>
                        </div>
                      </div>
                      <!-- END LOANS LIST TAB -->

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

  <script>
    $('#membersTable').dataTable({
      info: false,
      pagingType: "simple",
      "language": {
        "emptyTable": "No data available in table",
        "search": "Search:",
        "zeroRecords": "No matching records found",
        "paginate": {
          "next": "<button class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
          "previous": "<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>"
        }
      }
    });
  </script>

  <script>
    function calcTotal() {
      var amount = parseFloat(document.getElementById('amount').value) || 0;
      var rate   = parseFloat(document.getElementById('interest_rate').value) || 0;
      var total  = amount * (1 + rate / 100);
      document.getElementById('total_payable').value = total > 0 ? total.toFixed(2) : '';
    }
    document.getElementById('amount').addEventListener('input', calcTotal);
    document.getElementById('interest_rate').addEventListener('input', calcTotal);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function goBack() { window.history.back(); }
  </script>

</body>
</html>