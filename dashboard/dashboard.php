<?php
session_start();

// Check if the admin login form should be shown
$showAdminForm = isset($_GET['admin']) || !isset($_SESSION['is_admin']); // Show login if no session

$adminError = '';
// Handle POST request for login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if ($email === 'labinamehrin@gmail.com' && $password === '1234') {
        $_SESSION['is_admin'] = true; // Set session flag for admin
        header('Location: dashboard.php'); // Redirect to dashboard after successful login
        exit;
    } else {
        $adminError = 'Invalid email or password.';
        $showAdminForm = true; // Show form again with error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>LifeLine — Dashboard</title>

  <!-- Bootstrap + Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background: #f4f7fb; }
    .hero-card {
      max-width: 900px;
      border-radius: 24px;
      box-shadow: 0 8px 24px rgba(16,24,40,.06);
      border: 1px solid #e9eef5;
    }
    .hero-title {
      font-weight: 700;
      letter-spacing: .2px;
    }
    .action-btn {
      height: 122px;
      border-radius: 14px;
      border: 1px solid #e7ebf2 !important;
      background: #fff !important;
      transition: transform .05s ease, box-shadow .15s ease;
    }
    .action-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 6px 18px rgba(16,24,40,.08);
    }
    .action-icon { font-size: 2rem; line-height: 1; }
  </style>
</head>

<body>
  <!-- Page wrapper to center vertically -->
  <div class="min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card hero-card p-4 p-md-5 w-100">
      <h2 class="text-center hero-title mb-4">Welcome to LifeLine for the Missing</h2>

      <!-- 3x2 responsive grid -->
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        <div class="col">
          <a href="report_missing.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-plus-circle"></i></span>
            <span class="fw-semibold text-dark">Report Missing</span>
          </a>
        </div>

        <div class="col">
          <a href="list_missing.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-search"></i></span>
            <span class="fw-semibold text-dark">Find Someone</span>
          </a>
        </div>

        <div class="col">
          <a href="hospitals_shelters.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-building"></i></span>
            <span class="fw-semibold text-dark">Hospitals & Shelters</span>
          </a>
        </div>

        <div class="col">
          <a href="register_blood.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-droplet"></i></span>
            <span class="fw-semibold text-dark">Blood Needed Now</span>
          </a>
        </div>

        <div class="col">
          <a href="report_sighting.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-eye"></i></span>
            <span class="fw-semibold text-dark">Report a Sighting</span>
          </a>
        </div>

        <div class="col">
          <a href="donate.php" class="btn action-btn w-100 d-flex flex-column justify-content-center align-items-center">
            <span class="action-icon text-primary mb-2"><i class="bi bi-heart-fill"></i></span>
            <span class="fw-semibold text-dark">Donate</span>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Admin Panel Login Form -->
  <!-- <?php if ($showAdminForm): ?>
  <div class="d-flex justify-content-center mb-4">
    <form method="post" class="bg-light p-4 rounded-3 shadow-sm" style="min-width:300px;">
      <div class="mb-3">
        <label for="email" class="form-label">Admin Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <?php if ($adminError): ?>
        <div class="alert alert-danger py-2 mb-2"><?= htmlspecialchars($adminError) ?></div>
      <?php endif; ?>
      <button type="submit" name="admin_login" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
  <?php endif; ?> -->

  <!-- Admin Panel Link (Redirect to login) -->
  <div class="position-absolute top-0 end-0 p-3" style="z-index:10;">
    <a href="adminlogin.php" class="fw-bold text-primary text-decoration-none">Admin Panel</a>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


