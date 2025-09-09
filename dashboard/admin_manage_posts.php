<?php
session_start();
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: adminlogin.php');
    exit;
}
require_once '../db_connect.php';

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM missing_persons WHERE id = $id");
}

// Handle approve
if (isset($_GET['approve']) && is_numeric($_GET['approve'])) {
    $id = intval($_GET['approve']);
    $conn->query("UPDATE missing_persons SET status='APPROVED' WHERE id = $id");
}

// Fetch all posts
$result = $conn->query("SELECT * FROM missing_persons WHERE status='PENDING' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Missing Persons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f7fafd; }
        .admin-card { max-width: 900px; margin: 40px auto; }
        .post-card { background: #fff; border-radius: 14px; box-shadow: 0 4px 16px rgba(16,24,40,.08); padding: 1.2rem 1rem; margin-bottom: 1.2rem; }
        .post-photo { width: 56px; height: 56px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
<div class="admin-card">
    <h2 class="fw-bold mb-4 text-center">All Missing Person Posts</h2>
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="post-card d-flex align-items-center gap-3">
            <img src="<?= htmlspecialchars(json_decode($row['photos'])[0] ?? '') ?>" class="post-photo" alt="Photo">
            <div class="flex-grow-1">
                <div class="fw-bold" style="font-size:1.1rem;"><?= htmlspecialchars($row['full_name']) ?> <span class="text-muted small">Age <?= htmlspecialchars($row['age']) ?></span></div>
                <div class="small text-muted">Last seen: <?= htmlspecialchars($row['last_seen_location']) ?> &bull; <?= htmlspecialchars($row['last_seen_datetime']) ?></div>
                <span class="badge bg-primary"><?= htmlspecialchars($row['status']) ?></span>
            </div>
            <a href="?approve=<?= $row['id'] ?>" class="btn btn-success btn-sm ms-2" onclick="return confirm('Approve this post?');">Approve</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm ms-2" onclick="return confirm('Delete this post?');">Delete</a>
        </div>
    <?php endwhile; ?>
    <div class="mt-4 text-center">
        <a href="dashboard.php" class="btn btn-outline-secondary">Back to Dashboard</a>
    </div>
</div>
</body>
</html>
