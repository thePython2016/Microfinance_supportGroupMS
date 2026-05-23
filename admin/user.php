<style>
    .notification-badge {
      cursor: pointer;
    }
</style>
<div style="margin-right:50px !important;margin-top:30px">
  <i class="fas fa-bell fs-3"></i>
  <span class="position-absolute translate-middle badge rounded-pill notification-badge"
    style="background:#FB6542;" id="notification-badge" title="Sent Messages">
    <?php
    require 'connectDB.php';
    $countMessage = finance_db_query($connection, "SELECT count(id) as messagecount FROM sent_sms");
    $totalSMS = 0;
    foreach ($countMessage ?: [] as $message) {
        $totalSMS = $message['messagecount'] ?? 0;
        echo $totalSMS;
    }
    ?>
    <span class="visually-hidden">unread messages</span>
  </span>
</div>
<li class="nav-item">
  <script>
    document.getElementById("notification-badge").addEventListener("click", function () {
      alert("<?php echo 'You have ' . $totalSMS . ' sent messages'; ?>");
    });
  </script>

  <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
    <div class="avatar">
      <svg xmlns="http://www.w3.org/2000/svg" class="avatar1" viewBox="0 0 448 512">
        <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
      </svg>
    </div>
  </a>

  <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
    <li>
      <a class="dropdown-item" href="#">
        <div class="d-flex align-items-center">
          <div class="flex-shrink-0 me-2">
            <div class="avatar">
              <svg xmlns="http://www.w3.org/2000/svg" class="avatar2" viewBox="0 0 448 512">
                <path d="M304 128a80 80 0 1 0 -160 0 80 80 0 1 0 160 0zM96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM49.3 464l349.5 0c-8.9-63.3-63.3-112-129-112l-91.4 0c-65.7 0-120.1 48.7-129 112zM0 482.3C0 383.8 79.8 304 178.3 304l91.4 0C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7L29.7 512C13.3 512 0 498.7 0 482.3z"/>
              </svg>
            </div>
          </div>
          <div class="align-middle">
            <h6 class="mb-0 align-middle" style="padding-bottom:15px !important;padding-right:100px !important">
              <?php echo htmlspecialchars($_SESSION['username']); ?>
            </h6>
          </div>
        </div>
      </a>
    </li>
    <li><div class="dropdown-divider"></div></li>
    <li>
      <a class="dropdown-item" href="#">
        <i class="ri-user-3-line ri-22px me-2"></i>
        <span class="align-middle">My Profile</span>
      </a>
    </li>
    <li>
      <a class="dropdown-item" href="#">
        <i class="ri-settings-4-line ri-22px me-2"></i>
        <span class="align-middle">Settings</span>
      </a>
    </li>
    <li><div class="dropdown-divider"></div></li>
    <li>
      <div class="d-grid px-4 pt-2 pb-1">
        <a class="btn addBtn d-flex" href="../logout.php">
          <small class="align-middle">Logout</small>
          <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
        </a>
      </div>
    </li>
  </ul>
</li>