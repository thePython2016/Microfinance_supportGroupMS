<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$loginError = '';
if (!empty($_SESSION['login_error'])) {
    $loginError = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">

    

    <link rel="stylesheet" href="/css/register.css">
  </head>
  <body>

    <!-- ── Left column: no bg, css/login.css controls it ── -->
    <div class="left-col">
      <h1 class="welcome-title">Empower your learning<br>with our diverse tools</h1>
      <p class="welcome-sub">Embark on a knowledge journey with a wide array of powerful tools accessible through our intuitive system.</p>
    </div>

    <!-- ── Right column: registration form ── -->
    <div class="right-col">
      <div class="form-inner">

        <h1 class="form-headline">Register</h1>
        <p class="form-sub">Explore our system for free with a 2-day trial — no credit card required.</p>

        <?php if ($loginError !== ''): ?>
        <div class="error-msg">
          <i class="fa-solid fa-circle-exclamation"></i>
          <?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php endif; ?>

        <!-- ALL ORIGINAL FORM LOGIC PRESERVED -->
        <form name="form" action="authenticate.php" method="POST">

          <!-- Username -->
          <div class="field-wrap">
            <label for="usernameSelect">Username</label>
            <div class="field-input-wrap">
              <select id="usernameSelect" name="username" aria-label="Username" required>
                <option selected disabled value="">Select role</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
              </select>
              <i class="fa-solid fa-chevron-down field-icon" style="font-size:11px;"></i>
            </div>
          </div>

          <!-- Email -->
          <div class="field-wrap">
            <label for="emailInput">Email</label>
            <div class="field-input-wrap">
              <input type="email" id="emailInput" name="email" placeholder="Enter your email" required>
              <i class="fa-solid fa-envelope field-icon"></i>
            </div>
          </div>

          <!-- Password -->
          <div class="field-wrap">
            <label for="passwordInput">Password</label>
            <div class="field-input-wrap">
              <input type="password" id="passwordInput" name="password" placeholder="Enter your password" required>
              <i class="fa-solid fa-eye field-icon toggle-pw" id="togglePw"></i>
            </div>
          </div>

          <!-- Confirm Password -->
          <div class="field-wrap">
            <label for="confirmPasswordInput">Confirm password</label>
            <div class="field-input-wrap">
              <input type="password" id="confirmPasswordInput" name="confirm_password" placeholder="Confirm your password" required>
              <i class="fa-solid fa-eye field-icon toggle-pw" id="togglePw2"></i>
            </div>
          </div>

          <!-- Submit -->
          <button type="submit" name="submit" class="btn-register">Register now</button>

        </form>

          <p class="form-footer">
          Have an account? <a href="index.php">Login</a>
        </p>

        <p class="form-footer">
          Already have an account? <a href="index.php">Log in</a>
        </p>

      </div>
    </div>

    <script>
      // Password toggle 1
      const togglePw  = document.getElementById('togglePw');
      const pwInput   = document.getElementById('passwordInput');
      if (togglePw && pwInput) {
        togglePw.addEventListener('click', function() {
          const isText = pwInput.type === 'text';
          pwInput.type = isText ? 'password' : 'text';
          this.classList.toggle('fa-eye',       isText);
          this.classList.toggle('fa-eye-slash', !isText);
        });
      }
      // Password toggle 2
      const togglePw2  = document.getElementById('togglePw2');
      const pwInput2   = document.getElementById('confirmPasswordInput');
      if (togglePw2 && pwInput2) {
        togglePw2.addEventListener('click', function() {
          const isText = pwInput2.type === 'text';
          pwInput2.type = isText ? 'password' : 'text';
          this.classList.toggle('fa-eye',       isText);
          this.classList.toggle('fa-eye-slash', !isText);
        });
      }
    </script>

  </body>
</html>