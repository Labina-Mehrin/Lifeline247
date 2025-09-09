<?php
require_once '../db_connect.php';

$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;

// Fetch request info (optional, for header)
$request = null;
if ($request_id) {
    $req_sql = "SELECT * FROM requests WHERE id = $request_id";
    $req_result = $conn->query($req_sql);
    $request = $req_result->fetch_assoc();
}

// Fetch all responses for this request
$sql = "SELECT * FROM responses WHERE request_id = $request_id ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h3>Responses for Relief Request #<?= htmlspecialchars($request_id) ?></h3>
    <?php if ($request): ?>
        <div class="mb-3">
            <strong>Category:</strong> <?= htmlspecialchars(json_decode($request['fields_json'], true)['category'] ?? '') ?><br>
            <strong>Drop-off Point:</strong> <?= htmlspecialchars(json_decode($request['fields_json'], true)['dropoff'] ?? '') ?><br>
            <strong>Status:</strong> <?= htmlspecialchars($request['status']) ?>
        </div>
    <?php endif; ?>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Responder ID</th>
                <th>Message</th>
                <th>Evidence Type</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['responder_user_id']) ?></td>
                <td><?= htmlspecialchars($row['message']) ?></td>
                <td><?= htmlspecialchars($row['evidence_type']) ?></td>
                <td><?= htmlspecialchars($row['geo_lat']) ?></td>
                <td><?= htmlspecialchars($row['geo_lng']) ?></td>
                <td><?= htmlspecialchars($row['sighting_time']) ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="list_relief.php" class="btn btn-secondary">Back to List</a>
</div>