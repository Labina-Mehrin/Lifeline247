<?php
// report_missing.php
session_start();
$pending_status = 'PENDING';
$message = '';
$tracking_id = '';

require_once '../db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $age = trim($_POST['age']);
    $gender = trim($_POST['gender']);
    $last_seen_location = trim($_POST['last_seen_location']);
    $last_seen_lat = trim($_POST['last_seen_lat']);
    $last_seen_lng = trim($_POST['last_seen_lng']);
    $last_seen_datetime = trim($_POST['last_seen_datetime']);
    $identifying_features = trim($_POST['identifying_features']);
    $reporter_contact = trim($_POST['reporter_contact']);
    $relation = trim($_POST['relation']);
    $consent = isset($_POST['consent']) ? 1 : 0;
    $photos = [];

    // Handle photo upload (multiple)
    if (!empty($_FILES['photos']['name'][0])) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
        foreach ($_FILES['photos']['tmp_name'] as $i => $tmp_name) {
            if ($_FILES['photos']['error'][$i] === UPLOAD_ERR_OK) {
                $filename = uniqid('missing_', true) . '_' . basename($_FILES['photos']['name'][$i]);
                $target_file = $upload_dir . $filename;
                if (move_uploaded_file($tmp_name, $target_file)) {
                    $photos[] = 'uploads/' . $filename;
                }
            }
        }
    }
    $photos_json = json_encode($photos);

    // Generate tracking ID
    $tracking_id = strtoupper(substr(md5(uniqid()), 0, 8));

    // Insert into DB (status = PENDING)
    $stmt = $conn->prepare("INSERT INTO missing_persons (tracking_id, full_name, age, gender, last_seen_location, last_seen_lat, last_seen_lng, last_seen_datetime, identifying_features, photos, reporter_contact, relation, consent, status, created_at, reported_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)");
    $stmt->bind_param("ssssssssssssssi", $tracking_id, $full_name, $age, $gender, $last_seen_location, $last_seen_lat, $last_seen_lng, $last_seen_datetime, $identifying_features, $photos_json, $reporter_contact, $relation, $consent, $pending_status, $reported_by);
    if ($stmt->execute()) {
        $message = "Submission received! Your Tracking ID: <b>" . htmlspecialchars($tracking_id) . "</b>. Admin will review your report.";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report a Missing Person</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .map-container { height: 220px; border-radius: 8px; overflow: hidden; margin-bottom: 1rem; }
    </style>
</head>
<body>
<div class="container mt-5 mb-5" style="max-width: 600px;">
    <h2 class="mb-2">Report a Missing Person</h2>
    <p class="text-muted mb-4">Please provide details to help others recognize and locate the missing person. All submissions are verified before being made public.</p>
    <?php if ($message): ?>
        <div class="alert alert-info"> <?= $message ?> </div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" autocomplete="off">
        <div class="mb-3">
            <label class="form-label">Full Name *</label>
            <input type="text" name="full_name" class="form-control" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Age</label>
                <input type="number" name="age" class="form-control">
            </div>
            <div class="col">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Seen Location *</label>
            <input type="text" name="last_seen_location" id="last_seen_location" class="form-control mb-2" required>
            <div class="map-container" id="mapid"></div>
            <input type="hidden" name="last_seen_lat" id="last_seen_lat">
            <input type="hidden" name="last_seen_lng" id="last_seen_lng">
        </div>
        <div class="mb-3">
            <label class="form-label">Last Seen Date & Time *</label>
            <input type="datetime-local" name="last_seen_datetime" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Photo Upload *</label>
            <input type="file" name="photos[]" class="form-control" accept="image/*" multiple required>
            <small class="text-muted">Face-focused, recent if possible. You can upload multiple images.</small>
        </div>
        <div class="mb-3">
            <label class="form-label">Identifying Features</label>
            <input type="text" name="identifying_features" class="form-control" placeholder="Clothing, scars, height, etc.">
        </div>
        <div class="mb-3">
            <label class="form-label">Reporter’s Contact Info *</label>
            <input type="text" name="reporter_contact" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Relation to Person *</label>
            <select name="relation" class="form-select" required>
                <option value="">Select</option>
                <option value="Family">Family</option>
                <option value="Friend">Friend</option>
                <option value="Rescuer">Rescuer</option>
                <option value="NGO">NGO</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="consent" id="consent" required>
            <label class="form-check-label" for="consent">
                I confirm the information is correct and give permission to share it publicly for search purposes.
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
    </form>
    <div class="mt-4">
        <strong>Photo Guidelines:</strong> Face-focused, recent if possible.<br>
        <strong>Tip:</strong> The map helps others know where the person was last seen.
    </div>
</div>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Simple Leaflet map for pin drop
    var map = L.map('mapid').setView([23.685, 90.3563], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    var marker;
    map.on('click', function(e) {
        if (marker) map.removeLayer(marker);
        marker = L.marker(e.latlng).addTo(map);
        document.getElementById('last_seen_lat').value = e.latlng.lat;
        document.getElementById('last_seen_lng').value = e.latlng.lng;
    });
</script>
</body>
</html>
