<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loginError  = '';
$oldPhone    = $_SESSION['old_phone']    ?? '';
$oldAddress  = $_SESSION['old_address']  ?? '';

if (!empty($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
unset($_SESSION['old_phone'], $_SESSION['old_address']);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/register.css">
    <style>
      /* ── No-scroll fix ── */
      html, body {
        height: 100%;
        overflow: hidden;
      }
      body {
        display: flex;
        height: 100vh;
      }
      .left-col {
        height: 100vh;
        position: sticky;
        top: 0;
        flex-shrink: 0;
      }
      .right-col {
        flex: 1;
        height: 100vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
      }
      .form-inner {
        width: 100%;
        max-width: 420px;
      }
    </style>
  </head>
  <body>

    <div class="left-col">
      <span style="position:absolute;top:1.5rem;color:#ffffff;left:1.8rem;font-family:'DM Sans',sans-serif;font-weight:600;font-size:0.85rem;letter-spacing:0.2em;text-transform:uppercase;opacity:0.85;">MFGSMS</span>
      <h1 class="welcome-title">Welcome</h1>
  
    </div>

    <div class="right-col">
      <div class="form-inner">
        <h1 class="form-headline">Register</h1>
        <hr>

        <?php if ($loginError !== ''): ?>
        <div class="error-msg">
          <i class="fa-solid fa-circle-exclamation"></i>
          <?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php endif; ?>

        <form name="registerForm" action="auth.php" method="POST">

          <!-- Phone -->
          <div class="field-wrap">
            <label for="phoneInput">Phone</label>
            <div class="field-input-wrap">
              <input type="tel" id="phoneInput" name="phone"
                     placeholder="Enter your phone number"
                     value="<?= htmlspecialchars($oldPhone, ENT_QUOTES, 'UTF-8') ?>"
                     required maxlength="10" pattern="[0-9]{10}" inputmode="numeric"
                     oninput="this.value = this.value.replace(/\D/g,'').slice(0,10);">
              <i class="fa-solid fa-phone field-icon"></i>
            </div>
          </div>

          <!-- Address -->
          <div class="field-wrap">
            <label for="addressInput">Address</label>
            <div class="field-input-wrap">
              <input type="text" id="addressInput" name="address"
                     placeholder="Enter your address"
                     value="<?= htmlspecialchars($oldAddress, ENT_QUOTES, 'UTF-8') ?>"
                     required>
              <i class="fa-solid fa-location-dot field-icon"></i>
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

          <!-- Confirm Password -->
          <div class="field-wrap">
            <label for="confirmPasswordInput">Confirm Password</label>
            <div class="field-input-wrap">
              <input type="password" id="confirmPasswordInput" name="confirm_password"
                     placeholder="Confirm your password" required>
              <i class="fa-solid fa-eye field-icon toggle-pw" id="togglePw2"></i>
            </div>
          </div>

          <button type="submit" name="submit" class="btn-login">Register now</button>
        </form>

        <p class="form-footer">Already have an account? <a href="../index.php">Log in</a></p>
      </div>
    </div>

    <script>
      function togglePassword(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input  = document.getElementById(inputId);
        if (!toggle || !input) return;
        toggle.addEventListener('click', function () {
          const isText = input.type === 'text';
          input.type = isText ? 'password' : 'text';
          this.classList.toggle('fa-eye',       isText);
          this.classList.toggle('fa-eye-slash', !isText);
        });
      }
      togglePassword('togglePw',  'passwordInput');
      togglePassword('togglePw2', 'confirmPasswordInput');
    </script>
  </body>
</html>