<?php
require_once '../db_connect.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$person = null;
if ($id) {
    $result = $conn->query("SELECT * FROM missing_persons WHERE id = $id LIMIT 1");
    $person = $result->fetch_assoc();
}
if (!$person) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Person not found.</div></div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Missing Person Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { background: #f7fafd; }
    .profile-card {
      max-width: 400px;
      margin: 40px auto;
      background: #fff;
      border-radius: 18px;
      box-shadow: 0 8px 32px rgba(16,24,40,.10);
      padding: 2.2rem 2rem 1.5rem 2rem;
    }
    .profile-photo {
      width: 110px;
      height: 110px;
      object-fit: cover;
      border-radius: 50%;
      margin: 0 auto 1rem auto;
      display: block;
      border: 3px solid #e9eef5;
    }
    .badge-missing { background: #f44336; color: #fff; font-size: 1rem; }
    .badge-hospitalized { background: #ff9800; color: #fff; font-size: 1rem; }
    .badge-found { background: #ffe066; color: #333; font-size: 1rem; }
    .badge-reunited { background: #4caf50; color: #fff; font-size: 1rem; }
    .action-btn { min-width: 140px; }
    .timeline-icon { font-size: 1.1rem; margin-right: 6px; }
    .timeline-update { margin-bottom: 0.5rem; }
    .footer-link { font-size: 0.97rem; }
  </style>
</head>
<body>
  <div class="profile-card">
    <img src="<?= htmlspecialchars($person['image_path']) ?>" class="profile-photo" alt="Profile Photo">
    <div class="text-center mb-2">
      <div class="fw-bold" style="font-size:1.5rem;"><?= htmlspecialchars($person['name']) ?></div>
      <div class="text-muted mb-1"><?= htmlspecialchars($person['age']) ?> years old</div>
      <!-- Status badge logic -->
      <span class="badge <?= $person['status']=='missing'?'badge-missing':($person['status']=='hospitalized'?'badge-hospitalized':($person['status']=='found'?'badge-found':'badge-reunited')) ?> px-3 py-2">
        <?= ucfirst(htmlspecialchars($person['status'])) ?>
      </span>
    </div>
    <div class="mb-3 text-center">
      <div class="text-muted">Last seen: <?= htmlspecialchars($person['last_seen']) ?></div>
      <div class="text-muted">Date: <?= htmlspecialchars($person['last_seen_date']) ?></div>
    </div>
    <hr>
    <h5 class="mb-3">Timeline of Events & Sightings</h5>
    <?php
    // Fetch timeline updates
    $updates = [];
    $timeline_result = $conn->query("SELECT * FROM person_updates WHERE person_id = $id ORDER BY update_time DESC");
    while ($row = $timeline_result && $timeline_result->fetch_assoc()) {
      $updates[] = $row;
    }
    // Show notification if there are updates
    $show_notification = count($updates) > 0;
    $latest_update = $show_notification ? $updates[0] : null;
    ?>
    <div class="mb-3">
      <?php if ($updates): ?>
        <?php foreach ($updates as $update): ?>
          <div class="timeline-update">
            <span class="timeline-icon"><i class="bi bi-clock-history"></i></span>
            <strong><?= htmlspecialchars($update['update_type']) ?>:</strong>
            <?= htmlspecialchars($update['description']) ?>
            <span class="text-muted small ms-2">(<?= htmlspecialchars($update['update_time']) ?>)</span>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="text-muted">No updates yet.</div>
      <?php endif; ?>
    </div>
    <?php if ($show_notification && $latest_update): ?>
      <div id="updateNotification" style="position:fixed;bottom:32px;left:32px;z-index:9999;min-width:320px;max-width:360px;">
        <div class="bg-primary text-white rounded-4 shadow-lg p-3 d-flex align-items-center gap-3">
          <span class="bi bi-bell-fill fs-3"></span>
          <div>
            <div class="fw-bold">Update for Reported Person</div>
            <div><?= htmlspecialchars($latest_update['update_type']) ?>: <?= htmlspecialchars($latest_update['description']) ?></div>
            <div class="small text-white-50">(<?= htmlspecialchars($latest_update['update_time']) ?>)</div>
          </div>
        </div>
      </div>
      <script>
        setTimeout(function(){ document.getElementById('updateNotification').style.display = 'none'; }, 6000);
      </script>
    <?php endif; ?>
    <hr>
    <h5 class="mb-3">Report a Sighting</h5>
    <form method="post" class="mb-2">
      <div class="mb-2">
        <label class="form-label">Location</label>
        <input type="text" name="sighting_location" class="form-control" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Details</label>
        <textarea name="sighting_details" class="form-control" rows="2" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary w-100">Report Sighting</button>
    </form>
    <?php
    // Handle sighting submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sighting_location'], $_POST['sighting_details'])) {
      $loc = trim($_POST['sighting_location']);
      $det = trim($_POST['sighting_details']);
      $conn->query("INSERT INTO person_updates (person_id, update_type, description, update_time) VALUES ($id, 'Sighting', 'Location: $loc. Details: $det', NOW())");
      // Placeholder SMS notification logic
      $sms = '';
      $reporter_phone = '';
      $sms_opt_in = 0;
      $person_result = $conn->query("SELECT reporter_phone, sms_opt_in FROM missing_persons WHERE id = $id LIMIT 1");
      if ($person_result && $row = $person_result->fetch_assoc()) {
        $reporter_phone = $row['reporter_phone'];
        $sms_opt_in = $row['sms_opt_in'];
      }
      if ($sms_opt_in && $reporter_phone) {
        $sms = "(Placeholder) SMS notification would be sent to $reporter_phone about the new sighting.";
      }
      echo '<div class="alert alert-success mt-2">Sighting reported successfully!</div>';
      if ($sms) echo '<div class="alert alert-info">' . htmlspecialchars($sms) . '</div>';
      echo '<script>setTimeout(function(){ location.reload(); }, 1200);</script>';
    }
    <div class="mb-2">
      <!-- Last seen, features, etc. -->
      <div class="mb-1"><i class="bi bi-geo-alt text-primary"></i> <b>Last Seen</b> <?= htmlspecialchars($person['last_seen_location']) ?></div>
      <div class="text-muted small mb-2"><?= htmlspecialchars($person['last_seen_datetime']) ?></div>
      <div class="mb-1"><b>Identifying Features</b> <span class="text-muted small"><?= htmlspecialchars($person['identifying_features']) ?></span></div>
    </div>
    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-primary action-btn"><i class="bi bi-bell"></i> Subscribe for Updates</button>
      <button class="btn btn-outline-primary action-btn"><i class="bi bi-share"></i> Share</button>
    </div>
    <div class="d-flex gap-2 mb-3">
      <button class="btn btn-outline-secondary w-100"><i class="bi bi-eye"></i> Report a Sighting</button>
    </div>
    <hr>
    <div class="mb-2 fw-semibold">Updates</div>
    <div class="timeline-update"><i class="bi bi-eye timeline-icon"></i>Seen near Dhaka Medical <span class="text-muted small">Feb 15, 9:10 AM</span></div>
    <div class="timeline-update"><i class="bi bi-hospital timeline-icon"></i>Admitted to Dhaka Medical Hospital <span class="text-muted small">Feb 15, 10:00 AM</span></div>
    <hr>
    <div class="d-flex justify-content-between">
      <a href="list_missing.php" class="footer-link text-decoration-none">&larr; Back to Results</a>
      <a href="report_missing.php" class="footer-link text-decoration-none">Report Another Missing Person</a>
    </div>
  </div>
</body>
</html>
