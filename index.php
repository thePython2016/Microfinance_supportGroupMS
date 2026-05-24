<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loginError = '';
if (!empty($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
$success = '';
if (!empty($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    <style>
      /* flat labels — sit above the input, never cross the border */
      .field-wrap {
        display: flex;
        flex-direction: column;
        gap: 6px;
      }
      .field-wrap label {
        position: static !important;
        transform: none !important;
        font-size: 0.78rem;
        font-weight: 500;
        color: #555;
        margin-bottom: 0;
        padding: 0;
        background: transparent;
        pointer-events: none;
      }
      .field-input-wrap {
        position: relative;
      }
      .field-icon {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #bbb;
        font-size: 0.85rem;
        pointer-events: none;
      }
    </style>
  </head>
  <body>

    <!-- Left column -->
    <div class="left-col">
      <span style="position:absolute;top:1.5rem;left:1.8rem;color:#ffffff;font-family:'DM Sans',sans-serif;font-weight:600;font-size:0.85rem;letter-spacing:0.2em;text-transform:uppercase;opacity:0.85;">MFGSMS</span>
      <div class="deco deco-1"></div>
      <div class="deco deco-2"></div>
      <div class="deco deco-3"></div>
      <h1 class="welcome-title">Welcome<br>Back!</h1>
      <p class="welcome-sub">To keep connected with, please Create your account</p>
      <a href="registration/register.php" class="sign-in-btn">Register</a>
    </div>

    <!-- Right column -->
    <div class="right-col">
      <div class="form-inner">

        <h1 class="form-headline">Sign in to<br>your account</h1>

        <?php if ($loginError !== ''): ?>
        <div class="error-msg">
          <i class="fa-solid fa-circle-exclamation"></i>
          <?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php endif; ?>

        <?php if ($success !== ''): ?>
        <div class="error-msg" style="background:#edf5f1;border-color:#2d4a3e;color:#2d4a3e;">
          <i class="fa-solid fa-circle-check"></i>
          <?php echo htmlspecialchars($success, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php endif; ?>

        <form name="form" action="authenticate.php" method="POST">

          <!-- Phone -->
          <div class="field-wrap">
            <label for="phoneInput">Phone Number</label>
            <div class="field-input-wrap">
              <input type="tel" id="phoneInput" name="phone"
                     placeholder="Enter your phone number" required maxlength="10" pattern="[0-9]{10}" inputmode="numeric"
                     oninput="this.value = this.value.replace(/\D/g,'').slice(0,10);">
              <i class="fa-solid fa-phone field-icon"></i>
            </div>
          </div>

          <!-- Password -->
          <div class="field-wrap">
            <label for="passwordInput">Password</label>
            <div class="field-input-wrap">
              <input type="password" id="passwordInput" name="password"
                     placeholder="Enter your password" required>
              <i class="fa-solid fa-eye field-icon toggle-pw" id="togglePw"></i>
            </div>
          </div>

          <button type="submit" name="submit" class="btn-login">Sign In</button>
        </form>

        <p class="form-footer">
          Don't have an account? <a href="registration/register.php">Register</a>
        </p>

      </div>
    </div>

    <script>
      const togglePw = document.getElementById('togglePw');
      const pwInput  = document.getElementById('passwordInput');
      if (togglePw && pwInput) {
        togglePw.addEventListener('click', function () {
          const isText = pwInput.type === 'text';
          pwInput.type = isText ? 'password' : 'text';
          this.classList.toggle('fa-eye',       isText);
          this.classList.toggle('fa-eye-slash', !isText);
        });
      }
    </script>
  </body>
</html>