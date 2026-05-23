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

require "connectDB.php";

// ─── AJAX: return loan balance as JSON ───────────────────────────────────────
if (isset($_GET['ajax']) && $_GET['ajax'] === 'getLoanBalance') {
    header('Content-Type: application/json');
    $mobile = trim($_GET['mobile'] ?? '');
    if (empty($mobile)) { echo json_encode(['error' => 'No mobile']); exit; }
    try {
        $stmt = $connection->pdo->prepare(
            "SELECT id, loan_date, due_date, amount, interest_rate, total_payable, status
             FROM loans
             WHERE mobilenumber = :mobile
               AND status IN ('active','pending','overdue')
             ORDER BY loan_date ASC"
        );
        $stmt->execute([':mobile' => $mobile]);
        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['loans' => $loans, 'total_balance' => array_sum(array_column($loans, 'total_payable'))]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// ─── FORM SUBMIT: record payment and deduct from loans ───────────────────────
if (isset($_POST['payLoan'])) {
    $date   = $_POST['date']   ?? '';
    $mobile = $_POST['member'] ?? '';
    $amount = floatval($_POST['amount'] ?? 0);

    if (empty($date) || empty($mobile) || $amount <= 0) {
        $_SESSION['flash_error'] = "Please fill all fields correctly.";
        header("Location: " . $_SERVER["PHP_SELF"]); exit;
    }

    try {
        $pdo = $connection->pdo;
        $pdo->beginTransaction();

        // Insert payment record
        $pdo->prepare("INSERT INTO loanPayments (date, member, amount) VALUES (:date,:member,:amount)")
            ->execute([':date' => $date, ':member' => $mobile, ':amount' => $amount]);

        // Get active loans oldest first
        $stmt = $pdo->prepare(
            "SELECT id, total_payable FROM loans
             WHERE mobilenumber = :mobile AND status IN ('active','pending','overdue')
             ORDER BY loan_date ASC"
        );
        $stmt->execute([':mobile' => $mobile]);
        $loans = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($loans)) {
            $pdo->rollBack();
            $_SESSION['flash_error'] = "No active loans found for this member.";
            header("Location: " . $_SERVER["PHP_SELF"]); exit;
        }

        // ── SERVER-SIDE GUARD: payment must not exceed total outstanding balance ──
        $totalOutstanding = array_sum(array_column($loans, 'total_payable'));
        if ($amount > $totalOutstanding) {
            $pdo->rollBack();
            $_SESSION['flash_error'] = "Payment amount (TZS " . number_format($amount, 2) . ") exceeds the total outstanding balance of TZS " . number_format($totalOutstanding, 2) . ". Please enter a lower amount.";
            header("Location: " . $_SERVER["PHP_SELF"]); exit;
        }
        // ─────────────────────────────────────────────────────────────────────────

        // Deduct across loans (oldest first)
        $remaining  = $amount;
        $updateStmt = $pdo->prepare(
            "UPDATE loans
             SET total_payable = :bal,
                 status = CASE WHEN :bal2 <= 0 THEN 'paid' ELSE status END
             WHERE id = :id"
        );
        foreach ($loans as $loan) {
            if ($remaining <= 0) break;
            $current   = floatval($loan['total_payable']);
            $newBal    = max(0, $current - $remaining);
            $remaining = max(0, $remaining - $current);
            $updateStmt->execute([':bal' => $newBal, ':bal2' => $newBal, ':id' => $loan['id']]);
        }

        $pdo->commit();
        $_SESSION['flash_success'] = "Payment of TZS " . number_format($amount, 2) . " recorded successfully.";

    } catch (Exception $e) {
        if (isset($pdo)) $pdo->rollBack();
        $_SESSION['flash_error'] = "Error: " . $e->getMessage();
    }

    header("Location: " . $_SERVER["PHP_SELF"]); exit;
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

    <title>Loan Payment</title>

    <meta name="description" content="" />
   <!-- Datatable Top begin-->
   <link href="https://cdn.datatables.net/v/dt/dt-2.1.6/datatables.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">

   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

   <!-- Datatables End -->
   <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
   <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
      rel="stylesheet" />

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
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center"></div>
              </div>
              <ul class="navbar-nav flex-row align-items-center ms-auto">
              <?php require "user.php" ?>
                  </ul>
                </li>
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

              <div class="col-lg-12 col-md-12 col-12 mb-4">

                    <a class="btn addBtn" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">Add Payment</a>

</div>
<hr>

                <!-- Data Tables -->
                <div class="col-12">
                  <div class="card " style="margin-left:20px">
                    <div class="card-header" style="color:rgb(61, 60, 60) !important;font-size:16px;font-weight:bold">Loan Payment</div>

                    <div class="container mt-4">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab1-tab" data-bs-toggle="tab" href="#membersForm" role="tab" aria-controls="tab1" aria-selected="true">Loan Payment</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab3-tab" data-bs-toggle="tab" href="#editUpdate" role="tab" aria-controls="tab3" aria-selected="false">Payment List</a>
        </li>
    </ul>

    <div class="tab-content tabForms" id="myTabContent">
        <div class="tab-pane fade show active" id="membersForm" role="tabpanel" aria-labelledby="tab1-tab">

       <style>
         input[type="text"]   { background-color: white !important; }
         input[type="number"] { background-color: white !important; }
         select               { background-color: white; }
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

       <form id="payLoanForm" name="" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <div class="first-block">
        <div class="mb-3 nin">
    <label for="exampleInputEmail1" class="form-label" >Date</label>
    <input type="hidden" class="form-control" name="id" aria-describedby="emailHelp">
    <input type="date" class="form-control" name="date" id="date" aria-describedby="emailHelp" required>
  </div>

              <div class="mb-3 mobile">
    <label for="exampleInputEmail1" class="form-label" >Member</label>
    <select id="gender" class="form-control" name="member" required>
    <option value="" disabled selected>--Select Member--</option>
                <?php
$selectMember=finance_db_query($connection,"select * from members");
foreach($selectMember ?: [] as $member) { ?>
                <option value="<?php echo $member['mobileNumber']?>"><?php echo $member['mobileNumber'].' '.$member['fname'].' '.$member['lname']?></option>
               <?php } ?>
            </select>
  </div>
</div>

  <!-- ── Loan info box ── -->
  <div id="loadingBox" style="display:none;margin-bottom:16px;color:#555;">
    <i class="fas fa-spinner fa-spin me-2"></i> Fetching loan details...
  </div>
  <div id="noLoansBox" style="display:none;margin-bottom:16px;">
    <div class="alert alert-warning mb-0">
      <i class="fas fa-exclamation-triangle me-2"></i>This member has no active loans.
    </div>
  </div>
  <div id="loanInfoBox" style="display:none;margin-bottom:16px;">
    <div style="background:#f0f4ff;border:1px solid #c0cfe8;border-radius:8px;padding:16px;">
      <div style="font-weight:700;font-size:14px;color:#00246B;margin-bottom:10px;">
        <i class="fas fa-info-circle me-1"></i> Outstanding Loans
      </div>
      <div id="loansList"></div>
      <hr style="margin:8px 0;">
      <div style="display:flex;justify-content:space-between;font-weight:700;color:#333;">
        <span>Total Outstanding:</span>
        <span id="totalBalance" style="color:#c0392b;font-size:16px;"></span>
      </div>
      <div id="afterPaymentInfo" style="margin-top:8px;font-size:13px;"></div>
    </div>
  </div>
  <!-- ── end loan info box ── -->

  <div class="second-block">
  <div class="mb-3 fname">
    <label for="exampleInputPassword1" class="form-label">Amount</label>
    <input type="number" class="form-control" id="amount" name="amount" min="1" step="any">
  </div>
</div>

  <button type="submit" name="payLoan" class="btn  submitBtn">Submit</button>
</form>
        </div>

        <style>
              .hidden { display: none; }
        </style>
        <style>
          .dt-paging{ display:none !important; }
        </style>

        <div class="tab-pane fade" id="editUpdate" role="tabpanel" aria-labelledby="tab2-tab">
            <div class="container">
            <table id="membersTable" class="table mb-5 table-striped table-bordered" style="width:1000px !importnant">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Member number</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
              <?php
                 $selectShares=finance_db_query($connection,"select * from loanPayments");
                 foreach($selectShares ?: [] as $shares) { ?>
                <tr>
                <td><?php echo $shares['date']?></td>
                    <td><a href="member.php?number=<?php echo $shares['member']?>"><?php echo $shares['member']?></a></td>
                    <td><?php echo $shares['amount']?></td>
                </tr>
              <?php } ?>
            </tbody>
        </table>
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
    <script src="assets/js/dashboards-analytics.js"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Dataset SCRIPTS -->
    <script>
      $('#myTable').dataTable( {
        layout: { topStart: { buttons: ['print'] } },
        info:false,
        pagingType:"simple",
        "language": {
          "decimal":"","emptyTable":"No data available in table","info":"","infoFiltered":"","infoPostFix":"",
          "thousands":",","lengthMenu":"Show _MENU_ entries","processing":"","search":"Search:",
          "zeroRecords":"No matching records found","bProcessing":true,"sAutoWidth":false,"bDestroy":true,
          "sPaginationType":"bootstrap","iDisplayStart ":10,"iDisplayLength":10,
          "bPaginate":false,"bFilter":false,"bInfo":false,
          "paginate":{
            "next":"<button style='border:1px solid grey !important;color:grey;column-gap:0px'>Next</button>",
            "previous":"<button style='border:1px solid grey !important;color:grey;column-gap:0px'>Previous</button>"
          }
        }
      });

      $('#membersTable').dataTable( {
        info:false,
        pagingType:"simple",
        "language":{
          "decimal":"","emptyTable":"No data available in table","info":" ","infoFiltered":"","infoPostFix":"",
          "thousands":",","lengthMenu":"Show _MENU_ entries","ordering":"","processing":"","search":"Search:",
          "zeroRecords":"No matching records found",
          "paginate":{
            "next":"<button class='paging-button' style='border:1px solid grey !important;color:grey;margin:0'>Next</button>",
            "previous":"<button class='paging-button' style='border:1px solid grey !important;color:grey'>Previous</button>"
          }
        }
      });
    </script>

    <!-- Get Years / Months / Days — guarded, these fields don't exist on this page -->
<script>
    if (document.getElementById('yearField')) {
        const yearSelect = document.getElementById('yearField');
        for (let year = 1950; year <= 2006; year++) {
            let o = document.createElement('option'); o.value = o.textContent = year;
            yearSelect.appendChild(o);
        }
    }
    if (document.getElementById('monthField')) {
        const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
        const monthSelect = document.getElementById('monthField');
        months.forEach((month, index) => {
            let o = document.createElement('option'); o.value = index + 1; o.textContent = month;
            monthSelect.appendChild(o);
        });
    }
    if (document.getElementById('dayField')) {
        const daySelect = document.getElementById('dayField');
        for (let day = 1; day <= 31; day++) {
            let o = document.createElement('option'); o.value = o.textContent = day;
            daySelect.appendChild(o);
        }
    }
</script>

    <!-- TABS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DELETE SCRIPTS -->
    <script>
        $(document).ready(function() {
            let selectedId = null;
            $("tr").click(function() {
                $("tr").removeClass("selected");
                $(this).addClass("selected");
                selectedId = $(this).data("phone");
            });
            $("#delete-button").click(function() {
                if (selectedId === null) { alert("Please select a record to delete."); return; }
                if (confirm("Are you sure you want to delete this record?")) {
                    window.location.href = 'deleteMembers.php?id=' + selectedId;
                }
            });
        });
    </script>

    <script>
        function goBack() { window.history.back(); }
    </script>

    <!-- ── LOAN BALANCE AJAX + LIVE DEDUCTION PREVIEW + OVERPAYMENT GUARD ── -->
    <script>
      function fmt(n) {
        return 'TZS ' + parseFloat(n).toLocaleString('en', {minimumFractionDigits:2});
      }

      // ── Helper: check if entered amount is valid vs outstanding balance ──
      function amountIsOverLimit() {
        const box    = document.getElementById('loanInfoBox');
        const amount = parseFloat(document.getElementById('amount').value) || 0;
        const total  = parseFloat(box.dataset.total) || 0;
        return box.style.display !== 'none' && amount > total;
      }

      // When member dropdown changes → AJAX fetch outstanding loans
      document.getElementById('gender').addEventListener('change', function () {
        const mobile = this.value;

        document.getElementById('loanInfoBox').style.display  = 'none';
        document.getElementById('noLoansBox').style.display   = 'none';
        document.getElementById('loadingBox').style.display   = 'block';
        document.getElementById('afterPaymentInfo').innerHTML = '';
        document.getElementById('amount').value = '';

        // Reset amount field styling when member changes
        const amtField = document.getElementById('amount');
        amtField.style.border     = '';
        amtField.style.background = '';

        if (!mobile) { document.getElementById('loadingBox').style.display = 'none'; return; }

        fetch(window.location.pathname + '?ajax=getLoanBalance&mobile=' + encodeURIComponent(mobile))
          .then(r => {
            if (!r.ok) throw new Error('Server returned ' + r.status);
            return r.text().then(text => {
              try { return JSON.parse(text); }
              catch(e) { throw new Error('Invalid JSON: ' + text.substring(0, 200)); }
            });
          })
          .then(data => {
            document.getElementById('loadingBox').style.display = 'none';

            if (data.error) { alert('Error: ' + data.error); return; }

            if (!data.loans || data.loans.length === 0) {
              document.getElementById('noLoansBox').style.display = 'block';
              return;
            }

            const badgeMap = {active:'success', pending:'warning', overdue:'danger'};
            let html = `<table class="table table-sm table-bordered mb-0" style="font-size:13px;">
              <thead><tr>
                <th>Loan Date</th><th>Due Date</th><th>Original</th>
                <th>Interest</th><th>Balance Due</th><th>Status</th>
              </tr></thead><tbody>`;

            data.loans.forEach(loan => {
              const b = badgeMap[loan.status] || 'secondary';
              html += `<tr>
                <td>${loan.loan_date}</td>
                <td>${loan.due_date || '-'}</td>
                <td>${fmt(loan.amount)}</td>
                <td>${loan.interest_rate}%</td>
                <td><strong>${fmt(loan.total_payable)}</strong></td>
                <td><span class="badge bg-${b}">${loan.status}</span></td>
              </tr>`;
            });
            html += '</tbody></table>';

            document.getElementById('loansList').innerHTML = html;
            document.getElementById('totalBalance').textContent = fmt(data.total_balance);
            document.getElementById('loanInfoBox').dataset.total = data.total_balance;
            document.getElementById('loanInfoBox').style.display = 'block';
          })
          .catch((err) => {
            document.getElementById('loadingBox').style.display = 'none';
            alert('Failed to fetch loan data: ' + err.message);
          });
      });

      // ── Live preview: remaining balance + overpayment block ──
      document.getElementById('amount').addEventListener('input', function () {
        const box   = document.getElementById('loanInfoBox');
        const info  = document.getElementById('afterPaymentInfo');

        if (box.style.display === 'none') return;

        const total   = parseFloat(box.dataset.total) || 0;
        const payment = parseFloat(this.value) || 0;

        if (payment <= 0) {
          info.innerHTML        = '';
          this.style.border     = '';
          this.style.background = '';
          return;
        }

        const rem = total - payment;

        if (rem > 0) {
          // Valid partial payment
          info.innerHTML =
            `<span style="color:#27ae60;">
               <i class="fas fa-arrow-right me-1"></i>
               Remaining after payment: <strong>${fmt(rem)}</strong>
             </span>`;
          this.style.border     = '2px solid #27ae60';
          this.style.background = '#f0fff4';

        } else if (rem === 0) {
          // Exact full payment
          info.innerHTML =
            `<span style="color:#27ae60;font-weight:700;">
               <i class="fas fa-check-circle me-1"></i>
               This fully clears all loans!
             </span>`;
          this.style.border     = '2px solid #27ae60';
          this.style.background = '#f0fff4';

        } else {
          // ── OVER LIMIT ── red highlight + error message
          info.innerHTML =
            `<span style="color:#c0392b;font-weight:700;">
               <i class="fas fa-ban me-1"></i>
               Amount exceeds total outstanding balance of <strong>${fmt(total)}</strong>.
               Please enter a lower amount.
             </span>`;
          this.style.border     = '2px solid #c0392b';
          this.style.background = '#fff5f5';
        }
      });

      // ── Form submit guard: block if amount exceeds balance ──
      document.getElementById('payLoanForm').addEventListener('submit', function (e) {
        if (amountIsOverLimit()) {
          e.preventDefault();

          const box    = document.getElementById('loanInfoBox');
          const total  = parseFloat(box.dataset.total) || 0;
          const amount = parseFloat(document.getElementById('amount').value) || 0;

          document.getElementById('afterPaymentInfo').innerHTML =
            `<span style="color:#c0392b;font-weight:700;">
               <i class="fas fa-ban me-1"></i>
               Cannot submit — payment (${fmt(amount)}) exceeds outstanding balance (${fmt(total)}).
               Please correct the amount.
             </span>`;

          // Scroll to and focus the amount field
          const amtField = document.getElementById('amount');
          amtField.style.border     = '2px solid #c0392b';
          amtField.style.background = '#fff5f5';
          amtField.scrollIntoView({ behavior: 'smooth', block: 'center' });
          amtField.focus();

          return false;
        }
      });
    </script>

  </body>
</html>