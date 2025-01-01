<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>Clickable Alert Badge</title>
</head>
<body>

<!-- Alert Badge with Font Awesome Icon and Click Event -->
<div class="position-relative d-inline-block">
  <i class="fas fa-bell fs-3" id="notification-icon" style="cursor: pointer;"></i> <!-- Clickable Font Awesome Icon -->
  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notification-badge">
    5
    <span class="visually-hidden">unread messages</span>
  </span>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
  // JavaScript to handle click event on the icon
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("notification-icon").addEventListener("click", function() {
      // Show an alert when the icon is clicked
      alert("You have new notifications!");
      
      // Example: Hide the badge after clicking
      document.getElementById("notification-badge").style.display = "none";
    });
  });
</script>

</body>
</html>
