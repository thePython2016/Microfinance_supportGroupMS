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
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css">
	
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    
  </head>
  <body>

    <!-- ── Left column: welcome text ── -->
    <div class="left-col"s>
      <div class="deco deco-1"></div>
      <div class="deco deco-2"></div>
      <div class="deco deco-3"></div>
      <h1 class="welcome-title">Welcome<br>Back!</h1>
      <p class="welcome-sub">To keep connected with, please Create your account</p>
      <a href="#" class="sign-in-btn">Register</a>
    </div>

    <!-- ── Right column: login form ── -->
    <div class="right-col">
      <div class="form-inner">

     
        <h1 class="form-headline">Sign in to<br>your account</h1>

        <?php if ($loginError !== ''): ?>
        <div class="error-msg">
          <i class="fa-solid fa-circle-exclamation"></i>
          <?php echo htmlspecialchars($loginError, ENT_QUOTES, 'UTF-8'); ?>
        </div>
        <?php endif; ?>

        <!-- ALL ORIGINAL FORM LOGIC PRESERVED -->
        <form name="form" action="authenticate.php" method="POST">

          <!-- Username select -->
          <div class="field-wrap">
            <label for="usernameSelect">Username</label>
            <select id="usernameSelect" name="username" aria-label="Username" required>
              <option selected disabled value="">Select role</option>
              <option value="admin">Admin</option>
              <option value="staff">Staff</option>
            </select>
            <i class="fa-solid fa-chevron-down field-icon" style="font-size:12px;"></i>
          </div>

          <!-- Password -->
          <div class="field-wrap">
            <label for="passwordInput">Password</label>
            <input type="password" id="passwordInput" name="password" placeholder="Enter your password" required>
            <i class="fa-solid fa-eye field-icon toggle-pw" id="togglePw"></i>
          </div>

          <!-- Submit -->
          <button type="submit" name="submit" class="btn-login">Sign In</button>

        </form>

     
    </div>

    <script>
      const togglePw = document.getElementById('togglePw');
      const pwInput  = document.getElementById('passwordInput');
      if (togglePw && pwInput) {
        togglePw.addEventListener('click', function() {
          const isText = pwInput.type === 'text';
          pwInput.type = isText ? 'password' : 'text';
          this.classList.toggle('fa-eye',      isText);
          this.classList.toggle('fa-eye-slash', !isText);
        });
      }
    </script>

  </body>
</html>