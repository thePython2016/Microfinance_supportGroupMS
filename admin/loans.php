<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
if(!isset($_SESSION['username']))
{
  echo "<script>window.location.href='../index.php';</script>";
}
?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
  <title>Loans — MFSGMS</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- DataTables -->
  <link href="https://cdn.datatables.net/2.1.6/css/dataTables.bootstrap5.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/e5a3a8dd00.js" crossorigin="anonymous"></script>
  <!-- jQuery + DataTables -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>

  <style>
    :root {
      --navy:   #00246B;
      --gold:   #C9A84C;
      --gold-lt:#E8C97A;
      --cream:  #F8F5EE;
      --white:  #FFFFFF;
      --text:   #1a1a2e;
      --muted:  #6b7280;
      --border: #ddd6c8;
      --success:#16a34a;
      --danger: #dc2626;
      --radius: 10px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--cream);
      color: var(--text);
      min-height: 100vh;
    }

    /* ── SIDEBAR (unchanged wrapper) ── */
    .layout-wrapper { display: flex; min-height: 100vh; }
    .layout-page { flex: 1; display: flex; flex-direction: column; overflow: hidden; }

    /* ── NAVBAR ── */
    .layout-navbar {
      background: var(--white);
      border-bottom: 2px solid var(--gold);
      padding: 0 2rem;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* ── PAGE HEADER ── */
    .page-header {
      background: linear-gradient(135deg, var(--navy) 0%, #003580 100%);
      padding: 2rem 2.5rem 1.8rem;
      position: relative;
      overflow: hidden;
    }
    .page-header::after {
      content: '';
      position: absolute;
      right: -40px; top: -40px;
      width: 220px; height: 220px;
      border-radius: 50%;
      background: rgba(201,168,76,.15);
    }
    .page-header h1 {
      font-family: 'DM Serif Display', serif;
      color: var(--white);
      font-size: 1.9rem;
      font-weight: 400;
      letter-spacing: .02em;
    }
    .page-header p { color: rgba(255,255,255,.65); font-size: .85rem; margin-top: .25rem; }

    .btn-add-loan {
      background: var(--gold);
      color: var(--navy);
      font-weight: 600;
      font-size: .85rem;
      padding: .5rem 1.25rem;
      border-radius: 6px;
      border: none;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: .4rem;
      transition: background .2s, transform .15s;
    }
    .btn-add-loan:hover { background: var(--gold-lt); transform: translateY(-1px); color: var(--navy); }

    /* ── MAIN CONTENT ── */
    .content-area { padding: 2rem 2.5rem; flex: 1; }

    /* ── TABS ── */
    .custom-tabs { border-bottom: 2px solid var(--border); margin-bottom: 2rem; }
    .custom-tabs .nav-link {
      font-weight: 500;
      font-size: .88rem;
      color: var(--muted);
      padding: .75rem 1.4rem;
      border: none;
      background: transparent;
      position: relative;
      transition: color .2s;
    }
    .custom-tabs .nav-link::after {
      content: '';
      position: absolute;
      bottom: -2px; left: 0; right: 0;
      height: 2px;
      background: var(--navy);
      transform: scaleX(0);
      transition: transform .25s;
    }
    .custom-tabs .nav-link.active { color: var(--navy); }
    .custom-tabs .nav-link.active::after { transform: scaleX(1); }

    /* ── CARD ── */
    .form-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      padding: 2rem;
      box-shadow: 0 2px 16px rgba(0,0,0,.06);
    }
    .form-card .card-title {
      font-family: 'DM Serif Display', serif;
      font-size: 1.2rem;
      color: var(--navy);
      margin-bottom: 1.5rem;
      padding-bottom: .75rem;
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .form-card .card-title i { color: var(--gold); }

    /* ── SECTION LABELS ── */
    .section-label {
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: var(--gold);
      margin-bottom: .75rem;
      margin-top: 1.5rem;
    }
    .section-divider {
      border: none;
      border-top: 1px dashed var(--border);
      margin: 1.5rem 0;
    }

    /* ── FORM CONTROLS ── */
    .form-label {
      font-size: .8rem;
      font-weight: 600;
      color: var(--text);
      margin-bottom: .35rem;
      display: block;
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-label .badge-opt {
      font-size: .65rem;
      font-weight: 500;
      background: #f3f4f6;
      color: var(--muted);
      padding: 1px 6px;
      border-radius: 4px;
      margin-left: 4px;
    }

    .form-control, .form-select {
      border: 1.5px solid var(--border);
      border-radius: 7px;
      padding: .55rem .85rem;
      font-size: .875rem;
      background: #fff;
      color: var(--text);
      transition: border-color .2s, box-shadow .2s;
      width: 100%;
    }
    .form-control:focus, .form-select:focus {
      border-color: var(--navy);
      box-shadow: 0 0 0 3px rgba(0,36,107,.1);
      outline: none;
    }
    .form-control[readonly] { background: var(--cream); cursor: default; }

    /* calculated field highlight */
    .calc-field {
      background: #fffbeb !important;
      border-color: var(--gold) !important;
      font-weight: 600;
      color: var(--navy);
    }

    /* ── STATUS BADGES in select ── */
    .status-select { cursor: pointer; }

    /* ── SUBMIT ROW ── */
    .submit-row {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding-top: 1.5rem;
      border-top: 1px solid var(--border);
      margin-top: 1.5rem;
    }
    .btn-submit {
      background: var(--navy);
      color: var(--white);
      font-weight: 600;
      padding: .65rem 2rem;
      border: none;
      border-radius: 7px;
      font-size: .9rem;
      display: inline-flex;
      align-items: center;
      gap: .5rem;
      transition: background .2s, transform .15s;
    }
    .btn-submit:hover { background: #003580; transform: translateY(-1px); }
    .btn-reset {
      background: transparent;
      color: var(--muted);
      border: 1.5px solid var(--border);
      padding: .65rem 1.4rem;
      border-radius: 7px;
      font-size: .88rem;
      cursor: pointer;
      transition: border-color .2s, color .2s;
    }
    .btn-reset:hover { border-color: var(--danger); color: var(--danger); }

    /* ── ALERTS ── */
    .alert { border-radius: var(--radius); font-size: .87rem; }
    .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: var(--success); }
    .alert-danger  { background: #fef2f2; border: 1px solid #fecaca; color: var(--danger); }

    /* ── TABLE ── */
    #loansTable { width: 100% !important; font-size: .85rem; }
    #loansTable thead th {
      background: var(--navy);
      color: var(--white);
      font-weight: 600;
      font-size: .78rem;
      letter-spacing: .04em;
      text-transform: uppercase;
      padding: .85rem 1rem;
      border: none;
    }
    #loansTable tbody tr:hover { background: #f0f4ff; }
    #loansTable td { padding: .7rem 1rem; vertical-align: middle; }
    .status-badge {
      font-size: .72rem;
      font-weight: 700;
      padding: 3px 10px;
      border-radius: 20px;
      text-transform: uppercase;
      letter-spacing: .05em;
    }
    .status-active   { background:#dbeafe; color:#1d4ed8; }
    .status-paid     { background:#dcfce7; color:#15803d; }
    .status-overdue  { background:#fee2e2; color:#b91c1c; }
    .status-pending  { background:#fef9c3; color:#92400e; }

    /* ── FOOTER ── */
    footer {
      background: var(--white);
      border-top: 1px solid var(--border);
      padding: 1rem 2.5rem;
      font-size: .8rem;
      color: var(--muted);
    }

    /* ── HELPER HINT ── */
    .field-hint {
      font-size: .74rem;
      color: var(--muted);
      margin-top: .25rem;
    }

    /* ── INPUT GROUP prefix ── */
    .input-prefix {
      display: flex;
      align-items: stretch;
    }
    .input-prefix span {
      background: var(--cream);
      border: 1.5px solid var(--border);
      border-right: none;
      border-radius: 7px 0 0 7px;
      padding: 0 .75rem;
      display: flex;
      align-items: center;
      font-size: .85rem;
      color: var(--muted);
      font-weight: 600;
    }
    .input-prefix .form-control {
      border-radius: 0 7px 7px 0;
    }
  </style>
</head>

<body>
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    <!-- ── SIDEBAR ── -->
    <?php require "menu.php" ?>

    <!-- ── LAYOUT PAGE ── -->
    <div class="layout-page">

      <!-- NAVBAR -->
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

      <!-- CONTENT WRAPPER -->
      <div class="content-wrapper">

        <!-- PAGE HEADER -->
        <div class="page-header">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <h1><i class="fas fa-hand-holding-usd me-2" style="color:var(--gold)"></i>Loan Management</h1>
              <p>Record, track and manage member loans</p>
            </div>
            <a class="btn-add-loan" href="loans.php"><i class="fas fa-plus"></i> New Loan</a>
          </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="content-area">

          <!-- FLASH MESSAGES -->
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

          <!-- TABS -->
          <ul class="nav custom-tabs" id="loanTabs" role="tablist">
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

            <!-- ══════════════════════ ADD LOAN TAB ══════════════════════ -->
            <div class="tab-pane fade show active" id="addLoanTab">
              <div class="form-card">
                <div class="card-title"><i class="fas fa-file-invoice-dollar"></i> Loan Application</div>

                <form method="POST" action="loanAdd.php" id="loanForm">
                  <input type="hidden" name="id" id="loan_id">

                  <!-- ── SECTION 1: MEMBER INFO ── -->
                  <p class="section-label"><i class="fas fa-user me-1"></i>Member Information</p>
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label">Member <span class="req">*</span></label>
                      <select class="form-select" name="member_id" required>
                        <option value="" disabled selected>— Select Member —</option>
                        <?php
                          require "connectDB.php";
                          $members = finance_db_query($connection, "SELECT * FROM members");
                          foreach ($members ?: [] as $m):
                        ?>
                        <option value="<?= $m['mobileNumber'] ?>"><?= $m['mobileNumber'] . ' — ' . $m['fname'] . ' ' . $m['lname'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Status <span class="req">*</span></label>
                      <select class="form-select status-select" name="status" required>
                        <option value="active" selected>Active</option>
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="overdue">Overdue</option>
                      </select>
                    </div>
                  </div>

                  <hr class="section-divider">

                  <!-- ── SECTION 2: LOAN DETAILS ── -->
                  <p class="section-label"><i class="fas fa-coins me-1"></i>Loan Details</p>
                  <div class="row g-3">
                    <div class="col-md-4">
                      <label class="form-label">Principal Amount <span class="req">*</span></label>
                      <div class="input-prefix">
                        <span>TZS</span>
                        <input type="number" class="form-control" name="amount" id="amount" min="0" step="0.01" placeholder="0.00" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Interest Rate <span class="req">*</span></label>
                      <div class="input-prefix">
                        <span>%</span>
                        <input type="number" class="form-control" name="interest_rate" id="interest_rate" min="0" max="100" step="0.01" placeholder="0.00" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <label class="form-label">Total Payable <span class="badge-opt">auto-calculated</span></label>
                      <div class="input-prefix">
                        <span>TZS</span>
                        <input type="number" class="form-control calc-field" name="total_payable" id="total_payable" placeholder="0.00" readonly>
                      </div>
                      <p class="field-hint">Principal × (1 + Interest Rate / 100)</p>
                    </div>
                  </div>

                  <hr class="section-divider">

                  <!-- ── SECTION 3: DATES ── -->
                  <p class="section-label"><i class="fas fa-calendar-alt me-1"></i>Dates &amp; Period</p>
                  <div class="row g-3">
                    <div class="col-md-3">
                      <label class="form-label">Loan Date <span class="req">*</span></label>
                      <input type="date" class="form-control" name="loan_date" id="loan_date" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Due Date <span class="req">*</span></label>
                      <input type="date" class="form-control" name="due_date" id="due_date" required>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Month <span class="req">*</span></label>
                      <select class="form-select" name="month" id="month" required>
                        <option value="" disabled selected>— Month —</option>
                        <?php
                          $months = ['January','February','March','April','May','June',
                                     'July','August','September','October','November','December'];
                          foreach ($months as $i => $m):
                        ?>
                        <option value="<?= $i+1 ?>"><?= $m ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label class="form-label">Year <span class="req">*</span></label>
                      <select class="form-select" name="year" id="year" required>
                        <option value="" disabled selected>— Year —</option>
                        <?php for ($y = date('Y'); $y >= date('Y')-10; $y--): ?>
                        <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                        <?php endfor; ?>
                      </select>
                    </div>
                  </div>

                  <hr class="section-divider">

                  <!-- ── SECTION 4: NOTES ── -->
                  <p class="section-label"><i class="fas fa-sticky-note me-1"></i>Additional Notes</p>
                  <div class="row g-3">
                    <div class="col-12">
                      <label class="form-label">Notes <span class="badge-opt">optional</span></label>
                      <textarea class="form-control" name="notes" rows="3" placeholder="Any additional information about this loan…" style="resize:vertical"></textarea>
                    </div>
                  </div>

                  <!-- SUBMIT ROW -->
                  <div class="submit-row">
                    <button type="submit" name="addLoan" class="btn-submit">
                      <i class="fas fa-save"></i> Save Loan
                    </button>
                    <button type="reset" class="btn-reset" onclick="document.getElementById('total_payable').value=''">
                      <i class="fas fa-undo me-1"></i> Reset
                    </button>
                  </div>

                </form>
              </div>
            </div><!-- /addLoanTab -->

            <!-- ══════════════════════ LOANS LIST TAB ══════════════════════ -->
            <div class="tab-pane fade" id="loanListTab">
              <div class="form-card">
                <div class="card-title"><i class="fas fa-table"></i> All Loans</div>

                <div class="table-responsive">
                  <table id="loansTable" class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Loan Date</th>
                        <th>Due Date</th>
                        <th>Amount (TZS)</th>
                        <th>Interest %</th>
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
                        $statusMap = [
                          'active'  => 'status-active',
                          'paid'    => 'status-paid',
                          'overdue' => 'status-overdue',
                          'pending' => 'status-pending',
                        ];
                        foreach ($loans ?: [] as $l):
                          $sc = $statusMap[strtolower($l['status'] ?? '')] ?? 'status-pending';
                          $monthName = $months[($l['month'] ?? 1) - 1] ?? '—';
                      ?>
                      <tr>
                        <td><?= $l['id'] ?></td>
                        <td>
                          <a href="member.php?number=<?= htmlspecialchars($l['member_id']) ?>" style="color:var(--navy);font-weight:600;text-decoration:none">
                            <?= htmlspecialchars($l['member_id']) ?>
                          </a>
                        </td>
                        <td><?= htmlspecialchars($l['loan_date'] ?? '—') ?></td>
                        <td><?= htmlspecialchars($l['due_date'] ?? '—') ?></td>
                        <td><?= number_format($l['amount'], 2) ?></td>
                        <td><?= $l['interest_rate'] ?>%</td>
                        <td><strong><?= number_format($l['total_payable'], 2) ?></strong></td>
                        <td><?= $monthName ?></td>
                        <td><?= $l['year'] ?? '—' ?></td>
                        <td><span class="status-badge <?= $sc ?>"><?= ucfirst($l['status'] ?? 'pending') ?></span></td>
                        <td style="max-width:200px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis" title="<?= htmlspecialchars($l['notes'] ?? '') ?>">
                          <?= htmlspecialchars($l['notes'] ?? '—') ?>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div><!-- /loanListTab -->

          </div><!-- /tab-content -->
        </div><!-- /content-area -->

        <!-- FOOTER -->
        <footer class="content-footer">
          <div class="container-xxl">
            MFSGMS &copy; <script>document.write(new Date().getFullYear())</script> — All Rights Reserved
          </div>
        </footer>

      </div><!-- /content-wrapper -->
    </div><!-- /layout-page -->
  </div>
  <div class="layout-overlay layout-menu-toggle"></div>
</div>

<!-- ── SCRIPTS ── -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/js/menu.js"></script>

<script>
// DataTable
$(document).ready(function () {
  $('#loansTable').DataTable({
    pagingType: 'simple_numbers',
    pageLength: 10,
    language: {
      search: 'Filter:',
      zeroRecords: 'No loans found',
      info: 'Showing _START_–_END_ of _TOTAL_ loans',
      paginate: {
        next: 'Next →',
        previous: '← Prev'
      }
    }
  });
});

// Auto-calculate Total Payable
function calcTotal() {
  const amount = parseFloat(document.getElementById('amount').value) || 0;
  const rate   = parseFloat(document.getElementById('interest_rate').value) || 0;
  const total  = amount * (1 + rate / 100);
  document.getElementById('total_payable').value = total > 0 ? total.toFixed(2) : '';
}
document.getElementById('amount').addEventListener('input', calcTotal);
document.getElementById('interest_rate').addEventListener('input', calcTotal);

// Auto-fill month & year from loan_date
document.getElementById('loan_date').addEventListener('change', function () {
  const d = new Date(this.value);
  if (!isNaN(d)) {
    document.getElementById('month').value = d.getMonth() + 1;
    document.getElementById('year').value  = d.getFullYear();
  }
});
</script>

</body>
</html>