<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username']))
{
  echo "
  <script>
  window.location.href='../index.php';
  </script>
  ";
  exit;
}
require __DIR__ . "/connectDB.php";
require __DIR__ . "/chartsCodes.php";
require __DIR__ . '/dash.php';

// Ensure chart source arrays are defined even if the helper returns no rows.
$shareMonths = isset($shareMonths) ? $shareMonths : [];
$shareAmount = isset($shareAmount) ? $shareAmount : [];
$months = isset($months) ? $months : [];
$amount = isset($amount) ? $amount : [];
$activeLoans = isset($activeLoans) ? $activeLoans : 0;
$paidLoans = isset($paidLoans) ? $paidLoans : 0;
$pendingLoans = isset($pendingLoans) ? $pendingLoans : 0;
$overdueLoans = isset($overdueLoans) ? $overdueLoans : 0;

function loadFallbackChartData($connection, array &$shareMonths, array &$shareAmount, array &$months, array &$amount): void
{
    $shareMonths = [];
    $shareAmount = [];

    $shareQuery = "SELECT TO_CHAR(\"share_date\", 'YYYY-MM') AS month_key, SUM(amount) AS total FROM \"shares\" GROUP BY TO_CHAR(\"share_date\", 'YYYY-MM') ORDER BY MIN(\"share_date\") ASC";
    $shareResult = finance_db_query($connection, $shareQuery);
    if ($shareResult instanceof FinanceDbResult) {
        foreach ($shareResult as $row) {
            $monthKey = $row['month_key'] ?? $row['MONTH_KEY'] ?? null;
            if ($monthKey !== null) {
                $shareMonths[] = date('Y-M', strtotime($monthKey . '-01'));
                $shareAmount[] = (float)($row['total'] ?? 0);
            }
        }
    }

    $months = [];
    $amount = [];
    $loanQuery = "SELECT TO_CHAR(\"loan_date\", 'YYYY-MM') AS month_key, SUM(amount) AS total FROM \"loans\" GROUP BY TO_CHAR(\"loan_date\", 'YYYY-MM') ORDER BY MIN(\"loan_date\") ASC";
    $loanResult = finance_db_query($connection, $loanQuery);
    if ($loanResult instanceof FinanceDbResult) {
        foreach ($loanResult as $row) {
            $monthKey = $row['month_key'] ?? $row['MONTH_KEY'] ?? null;
            if ($monthKey !== null) {
                $months[] = date('Y-M', strtotime($monthKey . '-01'));
                $amount[] = (float)($row['total'] ?? 0);
            }
        }
    }
}

if (empty($shareMonths) || empty($shareAmount) || empty($months) || empty($amount)) {
    loadFallbackChartData($connection, $shareMonths, $shareAmount, $months, $amount);
}

$shareMonths = !empty($shareMonths) ? $shareMonths : ['No Data Available'];
$shareAmount = !empty($shareAmount) ? $shareAmount : [0];
$months = !empty($months) ? $months : ['No Data Available'];
$amount = !empty($amount) ? $amount : [0];
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

    <title>Home</title>

    <meta name="description" content="" />
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css" rel="stylesheet">
    
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap" rel="stylesheet" />
    <link rel="stylesheet" href="assets/vendor/fonts/remixicon/remixicon.css" />

    <link rel="stylesheet" href="assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/demo.css" />
    <link rel="stylesheet" href="assets/css/style.css" />

    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
    
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
    
    <style>
      .chart-container {
        position: relative;
        width: 100%;
        height: 360px; 
      }
      .dt-paging {
        display: none !important;
      }
      .hidden {
        display: none;
      }
      tr.selected {
        background-color: rgba(55, 94, 151, 0.15) !important;
      }
    </style>
  </head>

  <body>
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <?php require 'menu.php'; ?>
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
          <hr style="background:red !important;border:1px solid #00246B !important; margin: 0;">
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row gy-6">

                <div class="col-md-12">
                  <div class="card">
                    <div class="card-body py-4">
                      <div class="row g-6">
                        
                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockMember">
                            <div class="icon-section">
                              <div class="avatar-initial">
                                <svg xmlns="http://www.w3.org/2000/svg" class="members-icon" viewBox="0 0 640 512" style="width:24px; height:24px; fill:currentColor;"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                              </div>
                            </div>
                            <div class="ms-3 icon-text">
                              <p class="mb-0">Members</p>
                              <h5 class="mb-0"><?php echo htmlspecialchars($members); ?></h5>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockShares">
                            <div class="icon-section">
                              <div class="avatar-initial">
                                <svg xmlns="http://www.w3.org/2000/svg" class="share-icon" viewBox="0 0 512 512" style="width:24px; height:24px; fill:currentColor;"><path d="M64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L80 128c-8.8 0-16-7.2-16-16s7.2-16 16-16l368 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L64 32zM416 272a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg>
                              </div>
                            </div>
                            <div class="ms-3 icon-text">
                              <p class="mb-0">Shares (Tsh)</p>
                              <h5 class="mb-0"><?php echo htmlspecialchars($total); ?></h5>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-4 col-12">
                          <div class="d-flex align-items-center icon-blockLoan">
                            <div class="icon-section">
                              <div class="avatar-initial">
                                <svg xmlns="http://www.w3.org/2000/svg" class="loan-icon" viewBox="0 0 576 512" style="width:24px; height:24px; fill:currentColor;"><path d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg>
                              </div>
                            </div>
                            <div class="ms-3 icon-text">
                              <p class="mb-0">Loans (Tsh)</p>
                              <h5 class="mb-0"><?php echo htmlspecialchars($Total); ?></h5>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-5 col-md-6">
                  <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                      <h5 class="card-title m-0" style="color:rgb(61, 60, 60) !important; font-weight: 600;">Loan Status Breakdown Breakdown</h5>
                    </div>
                    <div class="card-body d-flex align-items-center justify-content-center">
                      <div class="chart-container">
                        <div id="loanStatusDoughnutMaster"></div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-xl-7 col-md-6">
                  <div class="row gy-6">
                    
                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h5 class="card-title m-0" style="color:rgb(61, 60, 60) !important; font-weight: 600;">Monthly Share Deposits Trend (TZS)</h5>
                        </div>
                        <div class="card-body">
                          <div class="chart-container" style="height: 160px;">
                            <div id="shareTrendLine"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="card">
                        <div class="card-header">
                          <h5 class="card-title m-0" style="color:rgb(61, 60, 60) !important; font-weight: 600;">Monthly Loan Issuance Trend (TZS)</h5>
                        </div>
                        <div class="card-body">
                          <div class="chart-container" style="height: 160px;">
                            <div id="loanTrendLine"></div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>

                <div class="col-12 mt-4">
                  <div class="card">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Members List</div>
                    <div class="card-body table-responsive">
                      <table id="membersTable" class="table table-striped table-bordered" style="width:100%;">
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
                          <?php 
                          require "connectDB.php";
                          $selectMembers = finance_db_query($connection, "SELECT * FROM members");
                          foreach($selectMembers ?: [] as $m) {
                            echo "<tr class='dataRow' data-phone='" . htmlspecialchars($m['mobileNumber']) . "' data-nin='" . htmlspecialchars($m['nin']) . "' data-fname='" . htmlspecialchars($m['fname']) . "' data-mname='" . htmlspecialchars($m['mname']) . "' data-lname='" . htmlspecialchars($m['lname']) . "' data-day='" . htmlspecialchars($m['day']) . "' data-month='" . htmlspecialchars($m['month']) . "' data-year='" . htmlspecialchars($m['year']) . "' data-gender='" . htmlspecialchars($m['gender']) . "' data-address='" . htmlspecialchars($m['address']) . "'>";
                            echo "<td>" . htmlspecialchars($m['mobileNumber']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['nin']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['fname']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['mname']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['lname']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['gender']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['day']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['month']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['year']) . "</td>";
                            echo "<td>" . htmlspecialchars($m['address']) . "</td>";
                            echo "</tr>";
                          }
                          ?>
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
          </div>
        </div>
      </div>
    </div>

    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>

    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
    <script src="assets/js/main.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function() {
        const statusLabels = ['Active', 'Pending', 'Paid', 'Overdue'];
        const statusCounts = [<?php echo $activeLoans; ?>, <?php echo $pendingLoans; ?>, <?php echo $paidLoans; ?>, <?php echo $overdueLoans; ?>];

        // The Grand High-Impact Unified Donut Layout Configuration
        const masterStatusChart = new ApexCharts(document.querySelector('#loanStatusDoughnutMaster'), {
          chart: { 
            height: 350, 
            type: 'donut',
            parentHeightOffset: 0
          },
          series: statusCounts,
          labels: statusLabels,
          colors: ['#28a745', '#ffc107', '#17a2b8', '#dc3545'],
          legend: { 
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '13px',
            fontFamily: 'Inter',
            offsetY: 5
          },
          dataLabels: { 
            enabled: true, 
            style: {
              fontSize: '12px',
              fontFamily: 'Inter',
              colors: ['#fff']
            },
            formatter: function(val) { return Math.round(val) + '%'; } 
          },
          stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
          },
          plotOptions: { 
            pie: { 
              donut: { 
                size: '72%',
                labels: {
                  show: true,
                  name: {
                    show: true,
                    fontSize: '14px',
                    fontFamily: 'Inter',
                    color: '#6c757d',
                    offsetY: -8
                  },
                  value: {
                    show: true,
                    fontSize: '24px',
                    fontFamily: 'Inter',
                    fontWeight: '600',
                    color: '#495057',
                    offsetY: 8,
                    formatter: function(val) {
                      return parseInt(val).toLocaleString();
                    }
                  },
                  total: {
                    show: true,
                    label: 'Total Record Count',
                    fontSize: '13px',
                    fontFamily: 'Inter',
                    color: '#878a99',
                    formatter: function (w) {
                      return w.globals.seriesTotals.reduce((a, b) => a + b, 0).toLocaleString();
                    }
                  }
                }
              } 
            } 
          },
          responsive: [{
            breakpoint: 600,
            options: {
              chart: { height: 280 },
              legend: { position: 'bottom' }
            }
          }]
        });
        masterStatusChart.render();

        const shareTrendChart = new ApexCharts(document.querySelector('#shareTrendLine'), {
          chart: { height: 160, type: 'line', toolbar: { show: false } },
          series: [{ name: 'Deposits', data: <?php echo json_encode($shareAmount); ?> }],
          stroke: { curve: 'smooth', width: 2 },
          markers: { size: 4 },
          xaxis: { categories: <?php echo json_encode($shareMonths); ?> },
          yaxis: { labels: { formatter: function(val) { return parseInt(val).toLocaleString() + ' TZS'; } } },
          tooltip: { y: { formatter: function(val) { return parseFloat(val).toLocaleString() + ' TZS'; } } },
          colors: ['#03a9f4'],
          legend: { show: false }
        });
        shareTrendChart.render();

        const loanTrendChart = new ApexCharts(document.querySelector('#loanTrendLine'), {
          chart: { height: 160, type: 'line', toolbar: { show: false } },
          series: [{ name: 'Issuance', data: <?php echo json_encode($amount); ?> }],
          stroke: { curve: 'smooth', width: 2 },
          markers: { size: 4 },
          xaxis: { categories: <?php echo json_encode($months); ?> },
          yaxis: { labels: { formatter: function(val) { return parseInt(val).toLocaleString() + ' TZS'; } } },
          tooltip: { y: { formatter: function(val) { return parseFloat(val).toLocaleString() + ' TZS'; } } },
          colors: ['#6610f2'],
          legend: { show: false }
        });
        loanTrendChart.render();

        $('#membersTable').DataTable({
          info: false,
          pagingType: 'simple',
          language: {
            search: 'Search:',
            zeroRecords: 'No matching records found',
            paginate: {
              next: "<button class='btn btn-sm btn-outline-secondary ms-1'>Next</button>",
              previous: "<button class='btn btn-sm btn-outline-secondary'>Previous</button>"
            }
          }
        });
      });
    </script>
  </body>
</html>