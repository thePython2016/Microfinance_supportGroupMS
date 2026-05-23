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
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Report</title>
    <meta name="description" content="" />

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>

    <!-- Theme assets -->
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
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
      /* ── Table containment — full visibility, wrap vertically ── */
      .box.container        { width: 100% !important; max-width: 100% !important; padding: 0 12px; }
      .table-wrap           { width: 100%; overflow-x: auto; }
      .box table            { width: 100% !important; table-layout: auto; font-size: 12px; }
      .box table th,
      .box table td         { overflow: visible !important;
                              text-overflow: unset !important;
                              white-space: normal !important;
                              word-break: break-word !important;
                              padding: 6px 8px !important;
                              vertical-align: top; }

      /* ══════════════════════════════════════════════════
         MEMBERS table — 11 cols, total = 100%
         Mobile(10) First(7) Mid(7) Last(7) Email(10)
         NIN(9) Gender(6) BDate(8) Address(9) Status(6) Joined(9) = ~98%
         ══════════════════════════════════════════════════ */
      #membersTable { font-size: 11px !important; }
      #membersTable th:nth-child(1),  #membersTable td:nth-child(1)  { width: 10%; }
      #membersTable th:nth-child(2),  #membersTable td:nth-child(2)  { width: 7%;   }
      #membersTable th:nth-child(3),  #membersTable td:nth-child(3)  { width: 7%;   }
      #membersTable th:nth-child(4),  #membersTable td:nth-child(4)  { width: 7%;   }
      #membersTable th:nth-child(5),  #membersTable td:nth-child(5)  { width: 10%;  }
      #membersTable th:nth-child(6),  #membersTable td:nth-child(6)  { width: 9%;   }
      #membersTable th:nth-child(7),  #membersTable td:nth-child(7)  { width: 6%;   }
      #membersTable th:nth-child(8),  #membersTable td:nth-child(8)  { width: 8%;   }
      #membersTable th:nth-child(9),  #membersTable td:nth-child(9)  { width: 9%;   }
      #membersTable th:nth-child(10), #membersTable td:nth-child(10) { width: 6%;   }
      #membersTable th:nth-child(11), #membersTable td:nth-child(11) { width: 9%;   }

      /* ══════════════════════════════════════════════════
         SHARES table — 4 cols, total = 100%
         Mobile(20) Name(35) Date(20) Amount(25)
         ══════════════════════════════════════════════════ */
      #sharesTable th:nth-child(1), #sharesTable td:nth-child(1) { width: 20%; }
      #sharesTable th:nth-child(2), #sharesTable td:nth-child(2) { width: 35%;  }
      #sharesTable th:nth-child(3), #sharesTable td:nth-child(3) { width: 20%;  }
      #sharesTable th:nth-child(4), #sharesTable td:nth-child(4) { width: 25%;  }

      /* ══════════════════════════════════════════════════
         LOANS table — 9 cols, total = 100%
         Mobile(12) Name(11) LDate(9) DDate(9) Amt(10)
         Rate(6) Payable(10) Status(7) Notes(10) = ~84% + gaps
         ══════════════════════════════════════════════════ */
      #loansTable { font-size: 11px !important; }
      #loansTable th:nth-child(1), #loansTable td:nth-child(1) { width: 12%; }
      #loansTable th:nth-child(2), #loansTable td:nth-child(2) { width: 11%;  }
      #loansTable th:nth-child(3), #loansTable td:nth-child(3) { width: 9%;   }
      #loansTable th:nth-child(4), #loansTable td:nth-child(4) { width: 9%;   }
      #loansTable th:nth-child(5), #loansTable td:nth-child(5) { width: 10%;  }
      #loansTable th:nth-child(6), #loansTable td:nth-child(6) { width: 6%;   }
      #loansTable th:nth-child(7), #loansTable td:nth-child(7) { width: 10%;  }
      #loansTable th:nth-child(8), #loansTable td:nth-child(8) { width: 7%;   }
      #loansTable th:nth-child(9), #loansTable td:nth-child(9) { width: 10%;  }

      /* ── DataTable toolbar ── */
      /* Final order: [Show N] | [From][To] | ---spacer--- | [Excel][PDF][Print] | [Search] */
      .dt-toolbar-row {
        display: flex !important;
        align-items: center !important;
        flex-wrap: nowrap !important;
        gap: 8px !important;
        margin-bottom: 8px !important;
        width: 100% !important;
      }
      .dt-toolbar-row > * { flex-shrink: 0; }

      /* Force every .dt-buttons into the row and kill any float DataTables applies */
      .dt-buttons {
        display: flex !important;
        flex-direction: row !important;
        gap: 4px !important;
        float: none !important;
        margin: 0 !important;
        padding: 0 !important;
        flex-shrink: 0 !important;
        position: static !important;
        order: 4 !important;
      }
      /* Length — order 1 */
      .dt-toolbar-row .dt-length {
        order: 1 !important;
        position: static !important;
        width: auto !important;
        margin: 0 !important;
      }
      /* Dates — order 2 */
      .dt-toolbar-row .date-filter-inline { order: 2 !important; }
      /* Spacer — order 3, eats remaining space */
      .dt-toolbar-row .dt-toolbar-spacer  { order: 3 !important; flex: 1 1 auto !important; }
      /* Search — order 5, far right */
      .dt-toolbar-row .dt-search {
        order: 5 !important;
        display: flex !important;
        align-items: center !important;
        gap: 4px !important;
        margin: 0 !important;
      }
      .dt-toolbar-row .dt-search label { margin: 0 !important; }
      .dt-toolbar-row .dt-search input[type="search"] {
        width: 130px !important;
        position: static !important;
        margin: 0 !important;
      }

      /* ── Inline date filter pair ── */
      .date-filter-inline {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        flex-shrink: 0;
      }
      .date-filter-inline .date-pair {
        display: flex;
        align-items: center;
        gap: 4px;
      }
      .date-filter-inline label {
        margin: 0;
        white-space: nowrap;
        font-size: 12px;
        font-weight: 500;
        color: #555;
      }
      .date-filter-inline input[type="date"] {
        width: 138px;
        height: 30px;
        padding: 2px 6px;
        font-size: 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background: #fff;
      }

      /* ── Hide all report blocks immediately — JS will show the right one ── */
      .box { display: none; }

      /* ── Hide pagination (as original) ── */
      .dt-paging { display: none !important; }

      /* ── Fix outer wrapper ── */
      div[style*="width:800px"] { width: 100% !important; }

      .table { margin-top: 10px !important; }
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

                <div class="col-lg-12 col-md-12 col-12 mb-4">
                  <button type="button" class="btn btn-success addBtn">Add Loan</button>
                </div>
                <hr>

                <div class="col-12">
                  <div class="card" style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61,60,60) !important;font-size:16px;font-weight:bold">Generate report</div>

                    <div class="nav-tabs mb-5 w-10">
                      <select id="reportSelect" class="form-select" style="width:1000px;margin:0 auto;" aria-label="Default select example">
                        <option value="choose">----Select----</option>
                        <option value="members">Members</option>
                        <option value="shares">Member by Shares</option>
                        <option value="loans">Member by Loan</option>
                      </select>
                    </div>

                    <div style="margin-bottom:20px !important;width:100%">

                      <!-- ═══════════════════════════════════════════
                           MEMBERS BLOCK
                           ═══════════════════════════════════════════ -->
                      <div class="members box container">
                        <div class="table-wrap">
                          <table id="membersTable" style="background:none !important" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th title="Mobile Number">Mobile No.</th>
                                <th title="First Name">First</th>
                                <th title="Middle Name">Middle</th>
                                <th title="Last Name">Last</th>
                                <th title="Email">Email</th>
                                <th title="NIN">NIN</th>
                                <th title="Gender">Gender</th>
                                <th title="Birth Date">Birth Date</th>
                                <th title="Physical Address">Address</th>
                                <th title="Status">Status</th>
                                <th title="Date Joined">Joined</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              require "connectDB.php";
                              $selectMembers = finance_db_query($connection, "select * from members");
                              foreach($selectMembers ?: [] as $m) {
                                  $mobile    = $m['mobileNumber'] ?? $m['mobilenumber'] ?? '';
                                  $fname     = $m['fname']     ?? '';
                                  $mname     = $m['mname']     ?? '';
                                  $lname     = $m['lname']     ?? '';
                                  $email     = $m['email']     ?? '';
                                  $nin       = $m['nin']       ?? '';
                                  $gender    = $m['gender']    ?? '';
                                  $day       = $m['day']       ?? '';
                                  $month     = $m['month']     ?? '';
                                  $yearRaw   = $m['year']      ?? '';
                                  $yearDisp  = '';
                                  if (!empty($yearRaw)) {
                                      $dt = date_create($yearRaw);
                                      $yearDisp = $dt ? date_format($dt, 'Y') : $yearRaw;
                                  }
                                  $birthDate  = trim("$day/$month/$yearDisp", '/');
                                  $address    = $m['address']   ?? '';
                                  $status     = $m['status']    ?? '';
                                  $joined     = $m['joined_at'] ?? '';
                                  $joinedDisp = '';
                                  if (!empty($joined)) {
                                      $dt = date_create($joined);
                                      $joinedDisp = $dt ? date_format($dt, 'Y-m-d') : $joined;
                                  }
                              ?>
                                <tr>
                                  <td title="<?php echo htmlspecialchars($mobile);     ?>"><a href="member.php?number=<?php echo urlencode($mobile); ?>"><?php echo htmlspecialchars($mobile); ?></a></td>
                                  <td title="<?php echo htmlspecialchars($fname);      ?>"><?php echo htmlspecialchars($fname);      ?></td>
                                  <td title="<?php echo htmlspecialchars($mname);      ?>"><?php echo htmlspecialchars($mname);      ?></td>
                                  <td title="<?php echo htmlspecialchars($lname);      ?>"><?php echo htmlspecialchars($lname);      ?></td>
                                  <td title="<?php echo htmlspecialchars($email);      ?>"><?php echo htmlspecialchars($email);      ?></td>
                                  <td title="<?php echo htmlspecialchars($nin);        ?>"><?php echo htmlspecialchars($nin);        ?></td>
                                  <td title="<?php echo htmlspecialchars($gender);     ?>"><?php echo htmlspecialchars($gender);     ?></td>
                                  <td title="<?php echo htmlspecialchars($birthDate);  ?>"><?php echo htmlspecialchars($birthDate);  ?></td>
                                  <td title="<?php echo htmlspecialchars($address);    ?>"><?php echo htmlspecialchars($address);    ?></td>
                                  <td title="<?php echo htmlspecialchars($status);     ?>"><?php echo htmlspecialchars($status);     ?></td>
                                  <td title="<?php echo htmlspecialchars($joinedDisp); ?>"><?php echo htmlspecialchars($joinedDisp); ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <!-- ═══════════════════════════════════════════
                           SHARES BLOCK
                           ═══════════════════════════════════════════ -->
                      <div class="shares box container">
                        <div class="table-wrap">
                          <table id="sharesTable" style="background:none !important" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th>Mobile Number</th>
                                <th>Member Name</th>
                                <th>Share Date</th>
                                <th>Amount (TZS)</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              require "connectDB.php";
                              try {
                                  $sharesResult = $connection->pdo->query(
                                      "SELECT s.*, m.fname, m.lname
                                       FROM shares s
                                       LEFT JOIN members m ON m.mobileNumber = s.member
                                       ORDER BY s.date DESC"
                                  );
                                  $selectShares = $sharesResult ? $sharesResult->fetchAll(PDO::FETCH_ASSOC) : [];
                              } catch (Exception $e) {
                                  $selectShares = [];
                              }
                              foreach($selectShares as $s) {
                                  $mobile   = $s['member'] ?? '';
                                  $fname    = $s['fname']  ?? '';
                                  $lname    = $s['lname']  ?? '';
                                  $fullName = trim("$fname $lname") ?: '-';
                                  $date     = $s['date']   ?? '';
                                  $amount   = $s['amount'] ?? 0;
                              ?>
                                <tr>
                                  <td title="<?php echo htmlspecialchars($mobile);   ?>"><a href="member.php?number=<?php echo urlencode($mobile); ?>"><?php echo htmlspecialchars($mobile); ?></a></td>
                                  <td title="<?php echo htmlspecialchars($fullName); ?>"><?php echo htmlspecialchars($fullName); ?></td>
                                  <td title="<?php echo htmlspecialchars($date);     ?>"><?php echo htmlspecialchars($date);     ?></td>
                                  <td title="<?php echo number_format((float)$amount, 2); ?>"><?php echo number_format((float)$amount, 2); ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                      <!-- ═══════════════════════════════════════════
                           LOANS BLOCK
                           ═══════════════════════════════════════════ -->
                      <div class="loans box container">
                        <div class="table-wrap">
                          <table id="loansTable" style="background:none !important" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th title="Mobile Number">Mobile No.</th>
                                <th title="Member Name">Name</th>
                                <th title="Loan Date">Loan Date</th>
                                <th title="Due Date">Due Date</th>
                                <th title="Amount (TZS)">Amount</th>
                                <th title="Interest Rate">Rate</th>
                                <th title="Total Payable (TZS)">Payable</th>
                                <th title="Status">Status</th>
                                <th title="Notes">Notes</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              require "connectDB.php";
                              try {
                                  $loansResult = $connection->pdo->query(
                                      "SELECT l.*, m.fname, m.lname
                                       FROM loans l
                                       INNER JOIN members m ON m.mobilenumber = l.mobilenumber
                                       ORDER BY l.loan_date DESC"
                                  );
                                  $selectLoans = $loansResult ? $loansResult->fetchAll(PDO::FETCH_ASSOC) : [];
                              } catch (Exception $e) {
                                  $selectLoans = [];
                              }
                              foreach($selectLoans as $l) {
                                  $mobile   = $l['mobilenumber']  ?? '';
                                  $fname    = $l['fname']          ?? '';
                                  $lname    = $l['lname']          ?? '';
                                  $fullName = trim("$fname $lname") ?: '-';
                                  $loanDate = $l['loan_date']      ?? '-';
                                  $dueDate  = $l['due_date']       ?? '-';
                                  $amount   = $l['amount']         ?? 0;
                                  $rate     = $l['interest_rate']  ?? '0';
                                  $payable  = $l['total_payable']  ?? 0;
                                  $status   = $l['status']         ?? '-';
                                  $notes    = $l['notes']          ?? '-';
                                  $badge = match($status) {
                                      'active'  => 'success',
                                      'pending' => 'warning',
                                      'paid'    => 'info',
                                      'overdue' => 'danger',
                                      default   => 'secondary'
                                  };
                              ?>
                                <tr>
                                  <td title="<?php echo htmlspecialchars($mobile);   ?>"><a href="member.php?number=<?php echo urlencode($mobile); ?>"><?php echo htmlspecialchars($mobile); ?></a></td>
                                  <td title="<?php echo htmlspecialchars($fullName); ?>"><?php echo htmlspecialchars($fullName);  ?></td>
                                  <td title="<?php echo htmlspecialchars($loanDate); ?>"><?php echo htmlspecialchars($loanDate);  ?></td>
                                  <td title="<?php echo htmlspecialchars($dueDate);  ?>"><?php echo htmlspecialchars($dueDate);   ?></td>
                                  <td title="<?php echo number_format((float)$amount,  2); ?>"><?php echo number_format((float)$amount,  2); ?></td>
                                  <td title="<?php echo htmlspecialchars($rate); ?>%"><?php echo htmlspecialchars($rate); ?>%</td>
                                  <td title="<?php echo number_format((float)$payable, 2); ?>"><?php echo number_format((float)$payable, 2); ?></td>
                                  <td title="<?php echo htmlspecialchars($status); ?>"><span class="badge bg-<?php echo $badge; ?>"><?php echo ucfirst($status); ?></span></td>
                                  <td title="<?php echo htmlspecialchars($notes); ?>"><?php echo htmlspecialchars($notes); ?></td>
                                </tr>
                              <?php } ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

                    </div><!-- /margin wrapper -->
                  </div><!-- /card -->
                </div><!-- /col-12 -->

              </div><!-- /row -->
            </div><!-- /container-xxl -->

            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="text-body mb-2 mb-md-0">
                    MFSGMS &copy;
                    <script>document.write(new Date().getFullYear());</script>
                    All Rights Reserved
                  </div>
                </div>
              </div>
            </footer>

            <div class="content-backdrop fade"></div>
          </div><!-- /content-wrapper -->
        </div><!-- /layout-page -->
      </div><!-- /layout-container -->

      <div class="layout-overlay layout-menu-toggle"></div>
    </div><!-- /layout-wrapper -->

    <!-- Vendor scripts -->
    <script src="assets/vendor/libs/node-waves/node-waves.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/dashboards-analytics.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- ═══════════════════════════════════════════════════════════
         MEMBERS DataTable — date filters inline in toolbar
         ═══════════════════════════════════════════════════════════ -->
    <script>
    $(document).ready(function () {
        var membersTable = $('#membersTable').DataTable({
            dom: "<'dt-toolbar-row'l <'members-date-wrap'> <'dt-toolbar-spacer'> B f>t",
            info: false,
            scrollX: false,
            autoWidth: false,
            buttons: [
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel fs-4"></i>', className: 'btn btn-success', titleAttr: 'Export to Excel' },
                { extend: 'pdfHtml5',   text: '<i class="fas fa-file-pdf fs-4"></i>',   className: 'btn btn-danger',  titleAttr: 'Export to PDF'   },
                { extend: 'print',      text: '<i class="fas fa-print fs-4"></i>',       className: 'btn btn-primary', titleAttr: 'Print'           }
            ],
            pageLength: 10,
            lengthMenu: [[5,10,25,50,-1],[5,10,25,50,"All"]],
            responsive: false,
            language: {
                decimal: "", emptyTable: "No data available in table", info: " ",
                infoFiltered: "", infoPostFix: "", thousands: ",",
                lengthMenu: "Show _MENU_ entries", ordering: "", processing: "",
                search: "Search:", zeroRecords: "No matching records found"
            },
            initComplete: function () {
                $('.members-date-wrap').addClass('date-filter-inline').html(
                    '<div class="date-pair"><label for="minDate">From:</label>' +
                    '<input type="date" id="minDate" class="form-control form-control-sm"></div>' +
                    '<div class="date-pair"><label for="maxDate">To:</label>' +
                    '<input type="date" id="maxDate" class="form-control form-control-sm"></div>'
                );
                // Force buttons into the toolbar row directly before search
                var $toolbar = $('.members-date-wrap').closest('.dt-toolbar-row');
                var $search  = $toolbar.find('.dt-search');
                var $buttons = $('#membersTable').closest('.box').find('.dt-buttons');
                if ($buttons.length && $search.length) {
                    $buttons.detach().insertBefore($search);
                }
                $('#minDate, #maxDate').on('change', function () { membersTable.draw(); });
            }
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'membersTable') return true;
            var min  = $('#minDate').val();
            var max  = $('#maxDate').val();
            var cell = data[10];
            if (!min && !max) return true;
            var date = new Date(cell);
            if (isNaN(date)) return true;
            if (min && date < new Date(min)) return false;
            if (max && date > new Date(max)) return false;
            return true;
        });
    });
    </script>

    <!-- ═══════════════════════════════════════════════════════════
         SHARES DataTable — date filters inline in toolbar
         ═══════════════════════════════════════════════════════════ -->
    <script>
    $(document).ready(function () {
        var sharesTable = $('#sharesTable').DataTable({
            dom: "<'dt-toolbar-row'l <'shares-date-wrap'> <'dt-toolbar-spacer'> B f>t",
            info: false,
            scrollX: false,
            autoWidth: false,
            buttons: [
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel fs-4"></i>', className: 'btn btn-success', titleAttr: 'Export to Excel' },
                { extend: 'pdfHtml5',   text: '<i class="fas fa-file-pdf fs-4"></i>',   className: 'btn btn-danger',  titleAttr: 'Export to PDF'   },
                { extend: 'print',      text: '<i class="fas fa-print fs-4"></i>',       className: 'btn btn-primary', titleAttr: 'Print'           }
            ],
            pageLength: 10,
            lengthMenu: [[5,10,25,50,-1],[5,10,25,50,"All"]],
            responsive: false,
            language: {
                decimal: "", emptyTable: "No data available in table", info: " ",
                infoFiltered: "", infoPostFix: "", thousands: ",",
                lengthMenu: "Show _MENU_ entries", ordering: "", processing: "",
                search: "Search:", zeroRecords: "No matching records found"
            },
            initComplete: function () {
                $('.shares-date-wrap').addClass('date-filter-inline').html(
                    '<div class="date-pair"><label for="sharesMinDate">From:</label>' +
                    '<input type="date" id="sharesMinDate" class="form-control form-control-sm"></div>' +
                    '<div class="date-pair"><label for="sharesMaxDate">To:</label>' +
                    '<input type="date" id="sharesMaxDate" class="form-control form-control-sm"></div>'
                );
                var $toolbar = $('.shares-date-wrap').closest('.dt-toolbar-row');
                var $search  = $toolbar.find('.dt-search');
                var $buttons = $('#sharesTable').closest('.box').find('.dt-buttons');
                if ($buttons.length && $search.length) {
                    $buttons.detach().insertBefore($search);
                }
                $('#sharesMinDate, #sharesMaxDate').on('change', function () { sharesTable.draw(); });
            }
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'sharesTable') return true;
            var min  = $('#sharesMinDate').val();
            var max  = $('#sharesMaxDate').val();
            var cell = data[2];
            if (!min && !max) return true;
            var date = new Date(cell);
            if (isNaN(date)) return true;
            if (min && date < new Date(min)) return false;
            if (max && date > new Date(max)) return false;
            return true;
        });
    });
    </script>

    <!-- ═══════════════════════════════════════════════════════════
         LOANS DataTable — date filters inline in toolbar
         ═══════════════════════════════════════════════════════════ -->
    <script>
    $(document).ready(function () {
        var loansTable = $('#loansTable').DataTable({
            dom: "<'dt-toolbar-row'l <'loans-date-wrap'> <'dt-toolbar-spacer'> B f>t",
            info: false,
            scrollX: false,
            autoWidth: false,
            buttons: [
                { extend: 'excelHtml5', text: '<i class="fas fa-file-excel fs-4"></i>', className: 'btn btn-success', titleAttr: 'Export to Excel' },
                { extend: 'pdfHtml5',   text: '<i class="fas fa-file-pdf fs-4"></i>',   className: 'btn btn-danger',  titleAttr: 'Export to PDF'   },
                { extend: 'print',      text: '<i class="fas fa-print fs-4"></i>',       className: 'btn btn-primary', titleAttr: 'Print'           }
            ],
            pageLength: 10,
            lengthMenu: [[5,10,25,50,-1],[5,10,25,50,"All"]],
            responsive: false,
            language: {
                decimal: "", emptyTable: "No data available in table", info: " ",
                infoFiltered: "", infoPostFix: "", thousands: ",",
                lengthMenu: "Show _MENU_ entries", ordering: "", processing: "",
                search: "Search:", zeroRecords: "No matching records found"
            },
            initComplete: function () {
                $('.loans-date-wrap').addClass('date-filter-inline').html(
                    '<div class="date-pair"><label for="loansMinDate">From:</label>' +
                    '<input type="date" id="loansMinDate" class="form-control form-control-sm"></div>' +
                    '<div class="date-pair"><label for="loansMaxDate">To:</label>' +
                    '<input type="date" id="loansMaxDate" class="form-control form-control-sm"></div>'
                );
                var $toolbar = $('.loans-date-wrap').closest('.dt-toolbar-row');
                var $search  = $toolbar.find('.dt-search');
                var $buttons = $('#loansTable').closest('.box').find('.dt-buttons');
                if ($buttons.length && $search.length) {
                    $buttons.detach().insertBefore($search);
                }
                $('#loansMinDate, #loansMaxDate').on('change', function () { loansTable.draw(); });
            }
        });

        $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
            if (settings.nTable.id !== 'loansTable') return true;
            var min  = $('#loansMinDate').val();
            var max  = $('#loansMaxDate').val();
            var cell = data[2];
            if (!min && !max) return true;
            var date = new Date(cell);
            if (isNaN(date)) return true;
            if (min && date < new Date(min)) return false;
            if (max && date > new Date(max)) return false;
            return true;
        });
    });
    </script>

    <!-- ═══════════════════════════════════════════════════════════
         Row selection
         ═══════════════════════════════════════════════════════════ -->
    <script>
    $(document).ready(function () {
        let selectedId = null;
        $("tr").click(function () {
            $("tr").removeClass("selected");
            $(this).addClass("selected");
            selectedId = $(this).data("phone");
        });
        $("#delete-button").click(function () {
            if (selectedId === null) { alert("Please select a record to delete."); return; }
            if (confirm("Are you sure you want to delete this record?")) {
                window.location.href = 'deleteMembers.php?id=' + selectedId;
            }
        });
    });
    </script>

    <!-- ═══════════════════════════════════════════════════════════
         Dropdown — show/hide blocks
         ═══════════════════════════════════════════════════════════ -->
    <script>
    $(document).ready(function () {
        function applyReportFilter(val) {
            $(".box").hide();
            if (val === "members") { $(".members").show(); }
            if (val === "shares")  { $(".shares").show();  }
            if (val === "loans")   { $(".loans").show();   }
        }

        // Scope ONLY to the report dropdown — not DataTables length selects
        $("#reportSelect").on("change", function () {
            applyReportFilter($(this).val());
        });

        // Apply on page load using the current value
        applyReportFilter($("#reportSelect").val());
    });
    </script>

    <style>
      .green  { background: #00ff00; }
      .blue   { background: #0000ff; }
      .choose { background: #ffffff; }
    </style>

  </body>
</html>