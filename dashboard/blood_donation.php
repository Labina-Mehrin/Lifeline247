<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../reg_log/login.php');
    exit();
}
include '../db_connect.php';

// Handle donor registration
$donor_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register_donor'])) {
    $user_id = $_SESSION['user_id'];
    $name = $conn->real_escape_string($_POST['name']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $location = $conn->real_escape_string($_POST['location']);
    $contact = $conn->real_escape_string($_POST['contact']);

    $check = $conn->query("SELECT id FROM blood_donors WHERE user_id = $user_id");
    if ($check->num_rows > 0) {
        $donor_msg = '<div class="alert alert-warning">You are already registered as a donor.</div>';
    } else {
        $sql = "INSERT INTO blood_donors (user_id, name, blood_group, location, contact, registered_at) VALUES ($user_id, '$name', '$blood_group', '$location', '$contact', NOW())";
        if ($conn->query($sql)) {
            $donor_msg = '<div class="alert alert-success">Thank you for registering as a blood donor!</div>';
        } else {
            $donor_msg = '<div class="alert alert-danger">Registration failed. Please try again.</div>';
        }
    }
}

// Handle urgent blood request (for hospitals)
$request_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_request']) && $_SESSION['user_role'] === 'hospital') {
    $group = $conn->real_escape_string($_POST['request_group']);
    $type = $conn->real_escape_string($_POST['request_type']);
    $location = $conn->real_escape_string($_POST['request_location']);
    $details = $conn->real_escape_string($_POST['request_details']);

    $sql = "INSERT INTO blood_requests (hospital_id, blood_group, type, location, details, requested_at) VALUES ({$_SESSION['user_id']}, '$group', '$type', '$location', '$details', NOW())";
    if ($conn->query($sql)) {
        $request_msg = '<div class="alert alert-success">Urgent blood request posted!</div>';
    } else {
        $request_msg = '<div class="alert alert-danger">Failed to post request.</div>';
    }
}

// Fetch urgent requests
$requests = $conn->query("SELECT r.*, u.name AS hospital_name FROM blood_requests r JOIN users u ON r.hospital_id = u.id ORDER BY r.requested_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Blood Donation Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>Blood Donation Hub</h2>
    <a href="home_dashboard.php" class="btn btn-primary mb-3">&larr; Home</a>
    <p>Register as a donor, view urgent requests, and help save lives.</p>

    <!-- Donor Registration Form -->
    <div class="card mb-4">
        <div class="card-header bg-danger text-white">Register as a Blood Donor</div>
        <div class="card-body">
            <?php echo $donor_msg; ?>
            <form method="POST">
                <div class="mb-2">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo htmlspecialchars($_SESSION['user_name']); ?>">
                </div>
                <div class="mb-2">
                    <label>Blood Group</label>
                    <select name="blood_group" class="form-control" required>
                        <option value="">Select</option>
                        <option>A+</option><option>A-</option>
                        <option>B+</option><option>B-</option>
                        <option>AB+</option><option>AB-</option>
                        <option>O+</option><option>O-</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Contact</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
                <button type="submit" name="register_donor" class="btn btn-danger">Register</button>
            </form>
        </div>
    </div>

    <!-- Urgent Blood Request (Hospitals only) -->
    <?php if ($_SESSION['user_role'] === 'hospital'): ?>
    <div class="card mb-4">
        <div class="card-header bg-warning">Post Urgent Blood Request</div>
        <div class="card-body">
            <?php echo $request_msg; ?>
            <form method="POST">
                <div class="mb-2">
                    <label>Blood Group</label>
                    <select name="request_group" class="form-control" required>
                        <option value="">Select</option>
                        <option>A+</option><option>A-</option>
                        <option>B+</option><option>B-</option>
                        <option>AB+</option><option>AB-</option>
                        <option>O+</option><option>O-</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label>Type (Whole blood, Plasma, etc.)</label>
                    <input type="text" name="request_type" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Location</label>
                    <input type="text" name="request_location" class="form-control" required>
                </div>
                <div class="mb-2">
                    <label>Details</label>
                    <textarea name="request_details" class="form-control" required></textarea>
                </div>
                <button type="submit" name="post_request" class="btn btn-warning">Post Request</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- List of Urgent Requests -->
    <div class="card">
        <div class="card-header bg-info text-white">Urgent Blood Requests</div>
        <div class="card-body">
            <?php if ($requests && $requests->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Hospital</th>
                        <th>Blood Group</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Details</th>
                        <th>Requested At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($req = $requests->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($req['hospital_name']); ?></td>
                        <td><?php echo htmlspecialchars($req['blood_group']); ?></td>
                        <td><?php echo htmlspecialchars($req['type']); ?></td>
                        <td><?php echo htmlspecialchars($req['location']); ?></td>
                        <td><?php echo htmlspecialchars($req['details']); ?></td>
                        <td><?php echo htmlspecialchars($req['requested_at']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="alert alert-secondary">No urgent requests at the moment.</div>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
</html>