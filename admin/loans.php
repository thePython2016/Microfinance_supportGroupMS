<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username']))
{
  echo "<script>window.location.href='../index.php';</script>";
}
?>
<!doctype html>
<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
  data-style="light">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Loans — MFSGMS</title>
  <meta name="description" content="" />

  <!-- ── YOUR ORIGINAL ASSETS (unchanged) ── -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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

  <!-- ── NEW FORM STYLES (injected on top of your theme) ── -->
  <style>
    /* CSS variables scoped so they don't break existing theme */
    .loan-page {
      --lp-navy:   #00246B;
      --lp-gold:   #C9A84C;
      --lp-gold-lt:#E8C97A;
      --lp-cream:  #F8F5EE;
      --lp-border: #ddd6c8;
      --lp-muted:  #6b7280;
      --lp-danger: #dc2626;
      --lp-success:#16a34a;
      --lp-radius: 10px;
    }

    /* Page header banner */
    .lp-header {
      background: linear-gradient(135deg, var(--lp-navy) 0%, #003580 100%);
      border-radius: var(--lp-radius);
      padding: 1.5rem 2rem;
      margin-bottom: 1.5rem;
      position: relative;
      overflow: hidden;
    }
    .lp-header::after {
      content:'';position:absolute;right:-30px;top:-30px;
      width:160px;height:160px;border-radius:50%;
      background:rgba(201,168,76,.15);
    }
    .lp-header h4 {
      color:#fff;font-weight:700;margin:0;font-size:1.25rem;
      display:flex;align-items:center;gap:.5rem;
    }
    .lp-header p { color:rgba(255,255,255,.65);font-size:.82rem;margin:.25rem 0 0; }
    .lp-header .btn-new-loan {
      background:var(--lp-gold);color:var(--lp-navy);
      font-weight:700;font-size:.82rem;padding:.45rem 1.1rem;
      border-radius:6px;border:none;text-decoration:none;
      display:inline-flex;align-items:center;gap:.4rem;
      transition:background .2s;
    }
    .lp-header .btn-new-loan:hover { background:var(--lp-gold-lt); }

    /* Custom tabs */
    .lp-tabs { border-bottom:2px solid var(--lp-border);margin-bottom:1.5rem; }
    .lp-tabs .nav-link {
      font-size:.85rem;font-weight:600;color:var(--lp-muted);
      padding:.65rem 1.25rem;border:none;background:transparent;
      position:relative;transition:color .2s;border-radius:0;
    }
    .lp-tabs .nav-link::after {
      content:'';position:absolute;bottom:-2px;left:0;right:0;
      height:2px;background:var(--lp-navy);
      transform:scaleX(0);transition:transform .25s;
    }
    .lp-tabs .nav-link.active { color:var(--lp-navy); }
    .lp-tabs .nav-link.active::after { transform:scaleX(1); }

    /* Form card */
    .lp-card {
      background:#fff;
      border:1px solid var(--lp-border);
      border-radius:var(--lp-radius);
      padding:1.75rem;
      box-shadow:0 2px 12px rgba(0,0,0,.06);
    }
    .lp-card-title {
      font-size:1rem;font-weight:700;color:var(--lp-navy);
      margin-bottom:1.25rem;padding-bottom:.75rem;
      border-bottom:1px solid var(--lp-border);
      display:flex;align-items:center;gap:.5rem;
    }
    .lp-card-title i { color:var(--lp-gold); }

    /* Section labels */
    .lp-section {
      font-size:.68rem;font-weight:800;letter-spacing:.1em;
      text-transform:uppercase;color:var(--lp-gold);
      margin:1.25rem 0 .65rem;
    }
    .lp-divider {
      border:none;border-top:1px dashed var(--lp-border);margin:1.25rem 0;
    }

    /* Form controls override */
    .lp-label {
      font-size:.78rem;font-weight:600;color:#1a1a2e;
      display:block;margin-bottom:.3rem;
    }
    .lp-label .req { color:var(--lp-danger);margin-left:2px; }
    .lp-label .opt {
      font-size:.65rem;background:#f3f4f6;color:var(--lp-muted);
      padding:1px 5px;border-radius:3px;margin-left:4px;font-weight:500;
    }
    .lp-control {
      border:1.5px solid var(--lp-border) !important;
      border-radius:7px !important;
      padding:.52rem .8rem !important;
      font-size:.85rem !important;
      background:#fff !important;
      color:#1a1a2e !important;
      transition:border-color .2s,box-shadow .2s;
      width:100%;
    }
    .lp-control:focus {
      border-color:var(--lp-navy) !important;
      box-shadow:0 0 0 3px rgba(0,36,107,.1) !important;
      outline:none;
    }
    .lp-control[readonly] {
      background:#fffbeb !important;
      border-color:var(--lp-gold) !important;
      font-weight:700;color:var(--lp-navy) !important;
    }
    .lp-hint { font-size:.72rem;color:var(--lp-muted);margin-top:.2rem; }

    /* Input prefix group */
    .lp-prefix { display:flex; }
    .lp-prefix-text {
      background:var(--lp-cream);
      border:1.5px solid var(--lp-border);
      border-right:none;
      border-radius:7px 0 0 7px;
      padding:0 .7rem;
      display:flex;align-items:center;
      font-size:.82rem;color:var(--lp-muted);font-weight:700;
      white-space:nowrap;
    }
    .lp-prefix .lp-control { border-radius:0 7px 7px 0 !important; }

    /* Submit row */
    .lp-submit-row {
      display:flex;align-items:center;gap:.75rem;
      padding-top:1.25rem;
      border-top:1px solid var(--lp-border);
      margin-top:1.25rem;
    }
    .lp-btn-save {
      background:var(--lp-navy);color:#fff;
      font-weight:700;padding:.6rem 1.75rem;
      border:none;border-radius:7px;font-size:.88rem;
      display:inline-flex;align-items:center;gap:.45rem;
      cursor:pointer;transition:background .2s,transform .15s;
    }
    .lp-btn-save:hover { background:#003580;transform:translateY(-1px); }
    .lp-btn-reset {
      background:transparent;color:var(--lp-muted);
      border:1.5px solid var(--lp-border);
      padding:.6rem 1.25rem;border-radius:7px;font-size:.85rem;
      cursor:pointer;transition:border-color .2s,color .2s;
    }
    .lp-btn-reset:hover { border-color:var(--lp-danger);color:var(--lp-danger); }

    /* Alerts */
    .lp-alert-ok  { background:#f0fdf4;border:1px solid #bbf7d0;color:var(--lp-success);border-radius:8px;padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem; }
    .lp-alert-err { background:#fef2f2;border:1px solid #fecaca;color:var(--lp-danger); border-radius:8px;padding:.75rem 1rem;font-size:.85rem;margin-bottom:1rem; }

    /* Table header */
    #loansTable thead th {
      background:var(--lp-navy) !important;
      color:#fff !important;
      font-size:.75rem;
      letter-spacing:.04em;
      text-transform:uppercase;
      border:none !important;
    }
    #loansTable tbody tr:hover { background:#f0f4ff; }

    /* Status badges */
    .sbadge {
      font-size:.7rem;font-weight:800;
      padding:3px 9px;border-radius:20px;
      text-transform:uppercase;letter-spacing:.04em;
    }
    .sb-active  { background:#dbeafe;color:#1d4ed8; }
    .sb-paid    { background:#dcfce7;color:#15803d; }
    .sb-overdue { background:#fee2e2;color:#b91c1c; }
    .sb-pending { background:#fef9c3;color:#92400e; }
  </style>
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    <?php require "menu.php" ?>

    <div class="layout-page">
      <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)"><i class="ri-menu-fill ri-24px"></i></a>
        </div>
        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
          <ul class="navbar-nav flex-row align-items-center ms-auto">
            <?php require "user.php" ?>
          </ul>
        </div>
      </nav>
      <hr style="background:red !important;border:1px solid #00246B !important">

      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y loan-page">

          <!-- ── PAGE HEADER ── -->
          <div class="lp-header">
            <div class="d-flex align-items-center justify-content-between">
              <div>
                <h4><i class="fas fa-hand-holding-usd"></i> Loan Management</h4>
                <p>Record, track and manage member loans</p>
              </div>
              <a class="btn-new-loan" href="loans.php"><i class="fas fa-plus"></i> New Loan</a>
            </div>
          </div>

          <!-- ── FLASH MESSAGES ── -->
          <?php if (isset($_SESSION['flash_success'])): ?>
          <div class="lp-alert-ok"><i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
          <?php endif; ?>
          <?php if (isset($_SESSION['flash_error'])): ?>
          <div class="lp-alert-err"><i class="fas fa-exclamation-triangle me-2"></i><?php echo htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
          <?php endif; ?>

          <!-- ── TABS ── -->
          <ul class="nav lp-tabs" id="loanTabs">
            <li class="nav-item">
              <a class="nav-link active" data-bs-toggle="tab" href="#addLoanTab">
                <i class="fas fa-plus-circle me-1"></i> Add Loan
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#loanListTab">
                <i class="fas fa-list me-1"></i> Loans List
              </a>
            </li>
          </ul>

          <div class="tab-content">

            <!-- ══ ADD LOAN TAB ══ -->
            <div class="tab-pane fade show active" id="addLoanTab">
              <div class="lp-card">
                <div class="lp-card-title"><i class="fas fa-file-invoice-dollar"></i> Loan Application</div>

                <form method="POST" action="loanAdd.php" id="loanForm">
                  <input type="hidden" name="id" id="loan_id">

                  <!-- MEMBER INFO -->
                  <p class="lp-section"><i class="fas fa-user me-1"></i> Member Information</p>
                  <div class="row g-3">
                    <div class="col-md-8">
                      <label class="lp-label">Member <span class="req">*</span></label>
                      <select class="lp-control" name="member_id" required>
                        <option value="" disabled selected>— Select Member —</option>
                        <?php
                          require "connectDB.php";
                          $members = finance_db_query($connection, "SELECT * FROM members");
                          foreach ($members ?: [] as $m):
                        ?>
                        <option value="<?= htmlspecialchars($m['mobileNumber']) ?>">
                          <?= htmlspecialchars($m['mobileNumber'] . ' — ' . $m['fname'] . ' ' . $m['lname']) ?>
                        </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-4">
                      <label class="lp-label">Status <span class="req">*</span></label>
                      <select class="lp-control" name="status" required>
                        <option value="active" selected>Active</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                      </select>
                    </div>
                  </div>

                  <hr class="lp-divider">

                  <!-- LOAN DETAILS -->
                  <p class="lp-section"><i class="fas fa-coins me-1"></i> Loan Details</p>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="lp-label">Principal Amount <span class="req">*</span></label>
                      <div class="lp-prefix">
                        <span class="lp-prefix-text">TZS</span>
                        <input type="number" class="lp-control" name="amount" id="lpAmount" min="0" step="0.01" placeholder="0.00" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="lp-label">Interest Rate <span class="req">*</span></label>
                      <div class="lp-prefix">
                        <span class="lp-prefix-text">%</span>
                        <input type="number" class="lp-control" name="interest_rate" id="lpRate" min="0" max="100" step="0.01" placeholder="0.00" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="lp-label">Total Payable <span class="opt">auto-calculated</span></label>
                      <div class="lp-prefix">
                        <span class="lp-prefix-text">TZS</span>
                        <input type="number" class="lp-control" name="total_payable" id="lpTotal" placeholder="0.00" readonly>
                      </div>
                      <p class="lp-hint">Principal × (1 + Rate ÷ 100)</p>
                    </div>
                  </div>

                  <hr class="lp-divider">

                  <!-- DATES -->
                  <p class="lp-section"><i class="fas fa-calendar-alt me-1"></i> Dates &amp; Period</p>
                  <div class="row g-3">
                    <div class="col-md-3">
                      <label class="lp-label">Loan Date <span class="req">*</span></label>
                      <input type="date" class="lp-control" name="loan_date" id="lpLoanDate" required>
                    </div>
                    <div class="col-md-3">
                      <label class="lp-label">Due Date <span class="req">*</span></label>
                      <input type="date" class="lp-control" name="due_date" required>
                    </div>
                    <div class="col-md-3">
                      <label class="lp-label">Month <span class="req">*</span></label>
                      <select class="lp-control" name="month" id="lpMonth" required>
                        <option value="" disabled selected>— Month —</option>
                        <?php
                          $months=['January','February','March','April','May','June',
                                   'July','August','September','October','November','December'];
                          foreach($months as $i=>$m):
                        ?>
                        <option value="<?= $i+1 ?>"><?= $m ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="lp-label">Year <span class="req">*</span></label>
                      <select class="lp-control" name="year" id="lpYear" required>
                        <option value="" disabled selected>— Year —</option>
                        <?php for($y=date('Y');$y>=date('Y')-10;$y--): ?>
                        <option value="<?= $y ?>" <?= $y==date('Y')?'selected':'' ?>><?= $y ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                  </div>

                  <hr class="lp-divider">

                  <!-- NOTES -->
                  <p class="lp-section"><i class="fas fa-sticky-note me-1"></i> Notes</p>
                  <div class="row g-3">
                    <div class="col-12">
                      <label class="lp-label">Additional Notes <span class="opt">optional</span></label>
                      <textarea class="lp-control" name="notes" rows="3" placeholder="Any additional information about this loan…" style="resize:vertical"></textarea>
                    </div>
                  </div>

                  <!-- SUBMIT -->
                  <div class="lp-submit-row">
                    <button type="submit" name="addLoan" class="lp-btn-save">
                      <i class="fas fa-save"></i> Save Loan
                    </button>
                    <button type="reset" class="lp-btn-reset" onclick="document.getElementById('lpTotal').value=''">
                      <i class="fas fa-undo me-1"></i> Reset
                    </button>
                  </div>

                </form>
              </div>
            </div>
            <!-- /addLoanTab -->

            <!-- ══ LOANS LIST TAB ══ -->
            <div class="tab-pane fade" id="loanListTab">
              <div class="lp-card">
                <div class="lp-card-title"><i class="fas fa-table"></i> All Loans</div>
                <div class="table-responsive">
                  <table id="loansTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Loan Date</th>
                        <th>Due Date</th>
                        <th>Amount (TZS)</th>
                        <th>Rate %</th>
                        <th>Total Payable</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Status</th>
                        <th>Notes</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $loans = finance_db_query($connection, "SELECT * FROM loans ORDER BY loan_date DESC");
                        $sbMap = ['active'=>'sb-active','paid'=>'sb-paid','overdue'=>'sb-overdue','pending'=>'sb-pending'];
                        foreach ($loans ?: [] as $l):
                          $sc  = $sbMap[strtolower($l['status'] ?? '')] ?? 'sb-pending';
                          $mon = $months[($l['month'] ?? 1) - 1] ?? '—';
                      ?>
                      <tr>
                        <td><?= $l['id'] ?></td>
                        <td><a href="member.php?number=<?= htmlspecialchars($l['member_id']) ?>" style="color:var(--lp-navy);font-weight:600;text-decoration:none"><?= htmlspecialchars($l['member_id']) ?></a></td>
                        <td><?= htmlspecialchars($l['loan_date'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($l['due_date'] ?? '—') ?></td>
                        <td><?= number_format($l['amount'], 2) ?></td>
                        <td><?= $l['interest_rate'] ?>%</td>
                        <td><strong><?= number_format($l['total_payable'], 2) ?></strong></td>
                        <td><?= $mon ?></td>
                        <td><?= $l['year'] ?? '—' ?></td>
                        <td><span class="sbadge <?= $sc ?>"><?= ucfirst($l['status'] ?? 'pending') ?></span></td>
                        <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap" title="<?= htmlspecialchars($l['notes'] ?? '') ?>"><?= htmlspecialchars($l['notes'] ?? '—') ?></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- /loanListTab -->

          </div><!-- /tab-content -->
        </div><!-- /container -->

        <footer class="content-footer footer bg-footer-theme">
          <div class="container-xxl">
            <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
              <div class="text-body mb-2 mb-md-0">MFSGMS © <script>document.write(new Date().getFullYear())</script> All Rights Reserved</div>
            </div>
          </div>
        </footer>
        <div class="content-backdrop fade"></div>
      </div>
    </div>
  </div>
  <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- ── YOUR ORIGINAL SCRIPTS (unchanged) ── -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="assets/vendor/js/menu.js"></script>
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/dashboards-analytics.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.6/css/dataTables.dataTables.css" />
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
<script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.print.min.js"></script>

<!-- ── NEW PAGE SCRIPTS ── -->
<script>
$(document).ready(function () {
  // DataTable for loans list
  $('#loansTable').DataTable({
    pagingType: 'simple_numbers',
    pageLength: 10,
    language: {
      search: 'Filter:',
      zeroRecords: 'No loans found',
      info: 'Showing _START_–_END_ of _TOTAL_',
      paginate: { next: 'Next →', previous: '← Prev' }
    }
  });
});

// Auto-calculate total payable
function lpCalc() {
  const amt  = parseFloat(document.getElementById('lpAmount').value) || 0;
  const rate = parseFloat(document.getElementById('lpRate').value)   || 0;
  const tot  = amt * (1 + rate / 100);
  document.getElementById('lpTotal').value = tot > 0 ? tot.toFixed(2) : '';
}
document.getElementById('lpAmount').addEventListener('input', lpCalc);
document.getElementById('lpRate').addEventListener('input', lpCalc);

// Auto-fill month & year when loan date is picked
document.getElementById('lpLoanDate').addEventListener('change', function () {
  const d = new Date(this.value);
  if (!isNaN(d)) {
    document.getElementById('lpMonth').value = d.getMonth() + 1;
    document.getElementById('lpYear').value  = d.getFullYear();
  }
});
</script>

</body>
</html>