<?php
<?php
require_once '../db_connect.php';

$request_id = isset($_GET['request_id']) ? intval($_GET['request_id']) : 0;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = intval($_POST['request_id']);
    $responder_user_id = 1; // Replace with $_SESSION['user_id'] if using login
    $response_message = trim($_POST['response_message']);
    $evidence_type = trim($_POST['evidence_type']);
    $media = ''; // You can add file upload logic if needed
    $sighting_time = date('Y-m-d H:i:s');
    $geo_lat = !empty($_POST['geo_lat']) ? $_POST['geo_lat'] : null;
    $geo_lng = !empty($_POST['geo_lng']) ? $_POST['geo_lng'] : null;

    $stmt = $conn->prepare("INSERT INTO responses (request_id, responder_user_id, message, evidence_type, media, sighting_time, geo_lat, geo_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissssdd", $request_id, $responder_user_id, $response_message, $evidence_type, $media, $sighting_time, $geo_lat, $geo_lng);

    if ($stmt->execute()) {
        $message = "Response submitted successfully!";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Respond to Blood Request</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Respond to Blood Request</h3>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" class="mt-3">
        <input type="hidden" name="request_id" value="<?= htmlspecialchars($request_id) ?>">
        <div class="mb-3">
            <label class="form-label">Your Message</label>
            <textarea name="response_message" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Evidence Type</label>
            <select name="evidence_type" class="form-select" required>
                <option value="Donor Pledge">Donor Pledge</option>
                <option value="Photo">Photo</option>
                <option value="Document">Document</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Latitude (optional)</label>
            <input type="text" name="geo_lat" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Longitude (optional)</label>
            <input type="text" name="geo_lng" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Submit Response</button>
        <a href="list_blood.php" class="btn btn-secondary">Back to List</a>
    </form>
</div>
</body>
</html>