<?php
require_once '../db_connect.php';

$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$message = '';

// Handle selection of a response as donor
if (isset($_GET['select_response_id'])) {
    $response_id = intval($_GET['select_response_id']);
    // Mark this response as selected
    $conn->query("UPDATE responses SET selected_by_owner=1 WHERE id=$response_id");
    // Update request status to MATCHED
    $conn->query("UPDATE requests SET status='MATCHED' WHERE id=$request_id");
    $message = "Donor selected and request marked as MATCHED.";
}

// Fetch request info
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
    <h3>Responses for Blood Request #<?= htmlspecialchars($request_id) ?></h3>
    <?php if ($message): ?>
        <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <?php if ($request): ?>
        <div class="mb-3">
            <strong>Blood Group:</strong> <?= htmlspecialchars(json_decode($request['fields_json'], true)['blood_group'] ?? '') ?><br>
            <strong>Facility:</strong> <?= htmlspecialchars(json_decode($request['fields_json'], true)['facility'] ?? '') ?><br>
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
                <th>Action</th>
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
                <td>
                    <?php if (!$row['selected_by_owner']): ?>
                        <a href="view_blood_responses.php?request_id=<?= $request_id ?>&select_response_id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Select as Donor</a>
                    <?php else: ?>
                        <span class="badge bg-success">Selected</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="list_blood.php" class="btn btn-secondary">Back to List</a>
</div>

<?php if ($request && $request['status'] === 'MATCHED' /* && $_SESSION['role'] === 'ADMIN' */): ?>
    <form method="post" class="mb-3">
        <input type="hidden" name="fulfill_request" value="1">
        <button type="submit" class="btn btn-warning">Mark as Fulfilled</button>
    </form>
<?php endif; ?>

<?php
// Handle admin fulfillment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fulfill_request'])) {
    $conn->query("UPDATE requests SET status='FULFILLED' WHERE id=$request_id");
    $message = "Request marked as FULFILLED.";
    // Optionally reload request info
    $req_result = $conn->query("SELECT * FROM requests WHERE id = $request_id");
    $request = $req_result->fetch_assoc();
}
?>