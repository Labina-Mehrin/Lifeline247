<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../reg_log/login.php');
    exit();
}
include '../db_connect.php';

$name = isset($_GET['name']) ? $conn->real_escape_string($_GET['name']) : '';
$location = isset($_GET['location']) ? $conn->real_escape_string($_GET['location']) : '';

$sql = "SELECT * FROM missing_persons WHERE 1";
if ($name) {
    $sql .= " AND name LIKE '%$name%'";
}
if ($location) {
    $sql .= " AND location LIKE '%$location%'";
}
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Search Missing Persons</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4">Search Results</h2>
    <a href="home_dashboard.php" class="btn btn-secondary mb-3">&larr; Back to Dashboard</a>
    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Contact</th>
                    <th>Features</th>
                    <th>Reported At</th>
                    <th>Actions</th> <!-- Added for update button -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['location']); ?></td>
                    <td><?php echo htmlspecialchars($row['contact']); ?></td>
                    <td><?php echo htmlspecialchars($row['features']); ?></td>
                    <td><?php echo htmlspecialchars($row['reported_at']); ?></td>
                    <td>
                        <?php if ($_SESSION['user_role'] === 'hospital'): ?>
                            <a href="update_missing.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Update</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No missing persons found matching your criteria.</div>
    <?php endif; ?>
</div>
</body>
</html>