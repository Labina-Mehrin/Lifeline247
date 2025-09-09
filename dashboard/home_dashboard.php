<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../reg_log/login.php');
    exit();
}

// Logout handler
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard - LifeLine for the Missing</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
        }
        .dashboard-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            overflow: hidden;
            margin-top: 6vh;
        }
        .card-header {
            background: linear-gradient(90deg, #0072ff 0%, #00c6ff 100%);
            color: #fff;
            text-align: center;
            padding: 2rem 1rem 1rem 1rem;
        }
        .btn-main {
            background: linear-gradient(90deg, #43c6ac 0%, #191654 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        .btn-main:hover {
            background: linear-gradient(90deg, #2e8b8b 0%, #191654 100%);
        }
        .logout-link {
            position: absolute;
            top: 30px;
            right: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="dashboard-card position-relative">
                <div class="card-header">
                    <h2>Dashboard</h2>
                    <p class="mb-0" style="font-size: 1.1rem;">Hello, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
                    <a href="?logout=1" class="btn btn-danger logout-link">Logout</a>
                </div>
                <div class="card-body text-center py-5">
                    <a href="blood_donation.php" class="btn btn-danger w-75 mb-3">Blood Donation Hub</a>
                    <a href="medical_relief.php" class="btn btn-success w-75 mb-3">Medical & Relief Donations Portal</a>
                    <a href="register_missing.php" class="btn btn-info w-75 mb-3">Report Missing</a>
                    <a href="list_missing.php" class="btn btn-info w-75 mb-3">Find Someone</a>
                    <a href="hospitals_shelters.php" class="btn btn-info w-75 mb-3">Hospitals & Shelters</a>
                    <a href="register_blood.php" class="btn btn-info w-75 mb-3">Blood Needed Now</a>
                    <a href="report_sighting.php" class="btn btn-info w-75 mb-3">Report a Sighting</a>
                    <a href="donate.php" class="btn btn-info w-75 mb-3">Donate</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
