<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username'])) {
  echo "<script>window.location.href='../index.php';</script>";
  exit;
}
require "connectDB.php";

// Initialize variables safely
$debug_count = 0;
$loanrecord = [];
$totalsMap = [];

try {
    // Main loans query
    $query = "SELECT m.mobilenumber, m.fname, m.lname, 
                     l.id, l.loan_date, l.due_date, l.amount, l.interest_rate, l.total_payable, l.status, l.notes
              FROM members m 
              INNER JOIN loans l ON m.mobilenumber = l.mobilenumber
              ORDER BY m.mobilenumber, l.loan_date DESC";
    
    $result = $connection->pdo->query($query);
    if ($result) {
        $loanrecord = $result->fetchAll(PDO::FETCH_ASSOC) ?: [];
        $debug_count = count($loanrecord);
    }

    // Per-member totals
    $totalQuery = "SELECT l.mobilenumber, m.fname, m.lname,
                          COUNT(*) as loan_count,
                          SUM(l.amount) as total_amount,
                          SUM(l.total_payable) as total_payable
                   FROM loans l
                   INNER JOIN members m ON m.mobilenumber = l.mobilenumber
                   GROUP BY l.mobilenumber, m.fname, m.lname";
    $totalResult = $connection->pdo->query($totalQuery);
    if ($totalResult) {
        foreach($totalResult->fetchAll(PDO::FETCH_ASSOC) as $t) {
            $totalsMap[$t['mobilenumber']] = $t;
        }
    }

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
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Check Loans</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

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

              <!-- SIDE-BY-SIDE RESPONSIVE LAYOUT DASHBOARD -->
              <?php if (isset($debug_count) && $debug_count > 0): ?>
              <div class="col-12 mb-4">
                <div class="row g-4 align-items-stretch">
                  
                  <!-- LEFT COLUMN: Status Donut Chart (Spans Tall) -->
                  <div class="col-xl-5 col-12">
                    <div class="card h-100 d-flex flex-column">
                      <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">Loan Status Breakdown</h5>
                      </div>
                      <div class="card-body d-flex align-items-center justify-content-center">
                        <div id="loanStatusChart" style="width: 100%;"></div>
                      </div>
                    </div>
                  </div>

                  <!-- RIGHT COLUMN: Stacked Line Charts -->
                  <div class="col-xl-7 col-12">
                    <div class="row g-4">
                      
                      <!-- Top Right Container: Monthly Share Deposits Line Chart -->
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">Monthly Share Deposits Trend (TZS)</h5>
                          </div>
                          <div class="card-body">
                            <div id="shareDepositChart"></div>
                          </div>
                        </div>
                      </div>

                      <!-- Bottom Right Container: Monthly Loan Issuance Line Chart -->
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0 me-2" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">Monthly Loan Issuance Trend (TZS)</h5>
                          </div>
                          <div class="card-body">
                            <div id="loanTrendChart"></div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div> <!-- End Right Column -->

                </div>
              </div>
              <?php endif; ?>

              <!-- LOAN RECORDS TABLE -->
              <div class="col-12">
                <div class="card" style="margin-left:20px">
                  <div class="card-header" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">
                    Member's Loans
                  </div>

                  <?php if ($debug_count == 0): ?>
                  <div style="background:#f8d7da;padding:15px;margin:15px;border:1px solid #f5c6cb;color:#721c24;">
                    <strong>⚠️ No loans found!</strong><br>
                    Make sure:<br>
                    1. <a href="setup-loans.php">Run setup-loans.php first</a> to add test members<br>
                    2. <a href="sync-loans.php">Run sync-loans.php</a> to create loans with matching mobile numbers
                  </div>
                  <?php else: ?>
                  <div style="background:#d4edda;padding:15px;margin:15px;border:1px solid #c3e6cb;color:#155724;">
                    ✓ Found <strong><?php echo $debug_count; ?> loan(s)</strong>
                  </div>
                  <?php endif; ?>

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
                            $badge = match(strtolower($status)) {
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
                            <td style="color:#fff !important;">
                              <?php echo htmlspecialchars(trim($t['fname'].' '.$t['lname'])); ?>
                            </td>
                            <td colspan="2" style="color:#fff !important;">
                              Loans: <strong><?php echo (int)$t['loan_count']; ?></strong>
                            </td>
                            <td style="color:#fff !important;">
                              <strong>TZS <?php echo number_format((float)$t['total_amount'], 2); ?></strong>
                            </td>
                            <td style="color:#fff !important;"></td>
                            <td style="color:#fff !important;">
                              <strong>TZS <?php echo number_format((float)$t['total_payable'], 2); ?></strong>
                            </td>
                            <td colspan="2" style="color:#fff !important;"></td>
                          </tr>
                          <?php endforeach; ?>

                          <!-- Grand total row -->
                          <tr style="background-color:#333 !important;color:#fff !important;font-weight:700;font-size:15px;">
                            <td colspan="5" style="color:#fff !important;text-align:right;padding-right:10px;">
                              Grand Total (All Members):
                            </td>
                            <td style="color:#fff !important;">
                              TZS <?php echo number_format(array_sum(array_column($totalsMap, 'total_amount')), 2); ?>
                            </td>
                            <td style="color:#fff !important;"></td>
                            <td style="color:#fff !important;">
                              TZS <?php echo number_format(array_sum(array_column($totalsMap, 'total_payable')), 2); ?>
                            </td>
                            <td colspan="2" style="color:#fff !important;"></td>
                          </tr>
                        </tfoot>
                      </table>
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

  <!-- JS Dependencies -->
  <script src="assets/vendor/libs/jquery/jquery.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/libs/popper/popper.js"></script>
  <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="assets/vendor/js/menu.js"></script>
  <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- DataTables Hooks -->
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
  <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

  <script src="assets/js/main.js"></script>
  <script src="assets/js/dashboards-analytics.js"></script>

  <script>
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

  <!-- Dynamic ApexCharts Pipeline Implementation -->
  <script>
    $(document).ready(function() {
      <?php
        // 1. Donut Chart Data (Status Breakdown)
        $statusCounts = ['active' => 0, 'pending' => 0, 'paid' => 0, 'overdue' => 0];
        foreach ($loanrecord as $loan) {
            $st = strtolower($loan['status'] ?? 'unknown');
            if (array_key_exists($st, $statusCounts)) {
                $statusCounts[$st]++;
            }
        }

        // 2. Timeline Aggregator Engine for both Monthly Trends
        $monthlyLoans = [];
        $monthlyDeposits = []; // Placeholder calculation array if you separate later
        
        foreach (array_reverse($loanrecord) as $loan) { 
            if (!empty($loan['loan_date'])) {
                $monthKey = date('Y-m', strtotime($loan['loan_date']));
                
                // Aggregate total amount loaned monthly
                if (!isset($monthlyLoans[$monthKey])) { $monthlyLoans[$monthKey] = 0.0; }
                $monthlyLoans[$monthKey] += (float)($loan['amount'] ?? 0);
                
                // For demonstration/calculation purposes based on your table payload,
                // total_payable minus base amount gives total expected returns/interests pool.
                if (!isset($monthlyDeposits[$monthKey])) { $monthlyDeposits[$monthKey] = 0.0; }
                $monthlyDeposits[$monthKey] += (float)($loan['total_payable'] ?? 0);
            }
        }
        
        // Chronological Key Sort
        ksort($monthlyLoans);
        ksort($monthlyDeposits);

        $trendLabels = [];
        $loanValues = [];
        $depositValues = [];

        foreach ($monthlyLoans as $dateKey => $amount) {
            $trendLabels[] = date('M Y', strtotime($dateKey . '-01'));
            $loanValues[] = $amount;
            $depositValues[] = $monthlyDeposits[$dateKey] ?? 0;
        }
      ?>

      // Deliver variables directly safely to JavaScript environment
      const statusData = <?php echo json_encode(array_values($statusCounts)); ?>;
      const statusLabels = <?php echo json_encode(array_map('ucfirst', array_keys($statusCounts))); ?>;
      const trendLabels = <?php echo json_encode($trendLabels); ?>;
      const loanValues = <?php echo json_encode($loanValues); ?>;
      const depositValues = <?php echo json_encode($depositValues); ?>;

      // 1. Render Tall Status Donut Chart
      if (document.querySelector("#loanStatusChart") && statusData.reduce((a, b) => a + b, 0) > 0) {
        new ApexCharts(document.querySelector("#loanStatusChart"), {
          chart: { height: 430, type: 'donut' },
          labels: statusLabels,
          series: statusData,
          colors: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
          dataLabels: {
            enabled: true,
            formatter: function (val) { return Math.round(val) + "%" }
          },
          legend: { position: 'bottom' }
        }).render();
      }

      // 2. Render Monthly Share Deposits Line Chart (Top Right)
      if (document.querySelector("#shareDepositChart") && trendLabels.length > 0) {
        new ApexCharts(document.querySelector("#shareDepositChart"), {
          chart: { height: 210, type: 'line', toolbar: { show: false } },
          stroke: { curve: 'smooth', width: 3 },
          series: [{ name: 'Share Contributions & Deposits', data: depositValues }],
          colors: ['#03a9f4'], // Light Blue Theme
          markers: { size: 4 },
          xaxis: { categories: trendLabels },
          yaxis: { labels: { formatter: function (val) { return parseInt(val).toLocaleString() + ' TZS'; } } },
          tooltip: { y: { formatter: function (val) { return parseFloat(val).toLocaleString() + ' TZS'; } } }
        }).render();
      }

      // 3. Render Monthly Loan Issuance Line Chart (Bottom Right)
      if (document.querySelector("#loanTrendChart") && trendLabels.length > 0) {
        new ApexCharts(document.querySelector("#loanTrendChart"), {
          chart: { height: 210, type: 'line', toolbar: { show: false } },
          stroke: { curve: 'smooth', width: 3 },
          series: [{ name: 'Total Disbursed', data: loanValues }],
          colors: ['#6610f2'], // Purple Theme
          markers: { size: 4 },
          xaxis: { categories: trendLabels },
          yaxis: { labels: { formatter: function (val) { return parseInt(val).toLocaleString() + ' TZS'; } } },
          tooltip: { y: { formatter: function (val) { return parseFloat(val).toLocaleString() + ' TZS'; } } }
        }).render();
      }
    });

    function goBack() { window.history.back(); }
  </script>
</body>
</html>