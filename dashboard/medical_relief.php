<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../reg_log/login.php');
    exit();
}
include '../db_connect.php';

// Handle donation form submission
$donation_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['donate'])) {
    $user_id = $_SESSION['user_id'];
    $donation_type = $conn->real_escape_string($_POST['donation_type']);
    $location = $conn->real_escape_string($_POST['location']);
    $details = $conn->real_escape_string($_POST['details']);
    $contact = $conn->real_escape_string($_POST['contact']);

    $sql = "INSERT INTO relief_donations (user_id, donation_type, location, details, contact, donated_at) VALUES ($user_id, '$donation_type', '$location', '$details', '$contact', NOW())";
    if ($conn->query($sql)) {
        $donation_msg = '<div class="alert alert-success">Thank you for your donation!</div>';
    } else {
        $donation_msg = '<div class="alert alert-danger">Donation failed. Please try again.</div>';
    }
}

// Handle hospital posting new needs
$need_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_need']) && $_SESSION['user_role'] === 'hospital') {
    $need_type = $conn->real_escape_string($_POST['need_type']);
    $location = $conn->real_escape_string($_POST['need_location']);
    $details = $conn->real_escape_string($_POST['need_details']);
    $contact = $conn->real_escape_string($_POST['need_contact']);

    $sql = "INSERT INTO relief_needs (need_type, location, details, contact, requested_at) VALUES ('$need_type', '$location', '$details', '$contact', NOW())";
    if ($conn->query($sql)) {
        $need_msg = '<div class="alert alert-success">Need posted successfully!</div>';
    } else {
        $need_msg = '<div class="alert alert-danger">Failed to post need.</div>';
    }
}

// Fetch real-time needs by location (example: last 10 requests)
$needs = $conn->query("SELECT * FROM relief_needs ORDER BY requested_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medical & Relief Donations Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>Medical & Relief Donations Portal</h2>
    <a href="home_dashboard.php" class="btn btn-primary mb-3">&larr; Home</a>
    <p>Donate medicines, saline, food, clothes, or funds to verified centers. View real-time needs by location.</p>

    <!-- Donation Form -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">Make a Donation</div>
        <div class="card-body">
            <?php echo $donation_msg; ?>
            <form method="POST">
                <div class="mb-2">
                    <label>Donation Type</label>
                    <select name="donation_type" class="form-control" required>
                        <option value="">Select</option>
                        <option value="Medicines">Medicines</option>
                        <option value="Saline">Saline</option>
                        <option value="Food">Food</option>
                        <option value="Clothes">Clothes</option>
                        <option value="Funds">Funds</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Details</label>
                    <textarea name="details" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
                <button type="submit" name="donate" class="btn btn-success">Donate</button>
            </form>
        </div>
    </div>

    <!-- Hospital Staff: Post Real-time Needs -->
    <?php if ($_SESSION['user_role'] === 'hospital'): ?>
    <div class="card mb-4">
        <div class="card-header bg-warning">Post Real-time Need (Hospitals Only)</div>
        <div class="card-body">
            <?php echo $need_msg; ?>
            <form method="POST">
                <div class="mb-2">
                    <label>Need Type</label>
                    <select name="need_type" class="form-control" required>
                        <option value="">Select</option>
                        <option value="Medicines">Medicines</option>
                        <option value="Saline">Saline</option>
                        <option value="Food">Food</option>
                        <option value="Clothes">Clothes</option>
                        <option value="Funds">Funds</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Location</label>
                    <input type="text" name="need_location" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Details</label>
                    <textarea name="need_details" class="form-control" required></textarea>
                </div>
                <div class="mb-2">
                    <label>Contact</label>
                    <input type="text" name="need_contact" class="form-control" required>
                </div>
                <button type="submit" name="post_need" class="btn btn-warning">Post Need</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Real-time Needs by Location -->
    <div class="card">
        <div class="card-header bg-info text-white">Real-time Needs by Location</div>
        <div class="card-body">
            <?php if ($needs && $needs->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Details</th>
                        <th>Requested At</th>
                        <th>Contact</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($need = $needs->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($need['need_type']); ?></td>
                        <td><?php echo htmlspecialchars($need['location']); ?></td>
                        <td><?php echo htmlspecialchars($need['details']); ?></td>
                        <td><?php echo htmlspecialchars($need['requested_at']); ?></td>
                        <td><?php echo htmlspecialchars($need['contact']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert alert-secondary">No current needs listed.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>