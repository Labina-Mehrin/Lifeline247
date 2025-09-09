<?php
require_once '../db_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $owner_user_id = 1; // Replace with $_SESSION['user_id'] if using login
    $title = "Blood Request: " . trim($_POST['blood_group']);
    $description = trim($_POST['details']);
    $type = 'BLOOD';
    $status = 'OPEN';
    $geo_lat = !empty($_POST['geo_lat']) ? $_POST['geo_lat'] : null;
    $geo_lng = !empty($_POST['geo_lng']) ? $_POST['geo_lng'] : null;
    $address = trim($_POST['address']);
    $district = trim($_POST['district']);
    $upazila = trim($_POST['upazila']);
    $fields_json = json_encode([
        'blood_group' => $_POST['blood_group'],
        'units' => $_POST['units'],
        'facility' => $_POST['facility'],
        'urgency' => $_POST['urgency'],
        'contact' => $_POST['contact']
    ]);

    $stmt = $conn->prepare("INSERT INTO requests (type, status, owner_user_id, title, description, geo_lat, geo_lng, address, district, upazila, fields_json) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissddssss", $type, $status, $owner_user_id, $title, $description, $geo_lat, $geo_lng, $address, $district, $upazila, $fields_json);

    if ($stmt->execute()) {
        $message = "Blood request registered successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Blood Request</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Register Blood Request</h3>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Blood Group</label>
            <input type="text" name="blood_group" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Units Needed</label>
            <input type="number" name="units" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Facility (Hospital/Clinic)</label>
            <input type="text" name="facility" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Urgency</label>
            <select name="urgency" class="form-select" required>
                <option value="Normal">Normal</option>
                <option value="Urgent">Urgent</option>
                <option value="Critical">Critical</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">District</label>
            <input type="text" name="district" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upazila</label>
            <input type="text" name="upazila" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Latitude</label>
            <input type="text" name="geo_lat" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Longitude</label>
            <input type="text" name="geo_lng" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Details</label>
            <textarea name="details" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Register</button>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
</body>
</html>