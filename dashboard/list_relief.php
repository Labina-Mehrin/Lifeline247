<?php
require_once '../db_connect.php';

// Fetch all relief requests (latest first)
$sql = "SELECT * FROM requests WHERE type='RELIEF' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h3>All Relief Requests</h3>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Category</th>
                <th>Quantity</th>
                <th>Drop-off Point</th>
                <th>Contact</th>
                <th>District</th>
                <th>Upazila</th>
                <th>Status</th>
                <th>Posted</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): 
            $fields = json_decode($row['fields_json'], true);
        ?>
            <tr>
                <td><?= htmlspecialchars($fields['category'] ?? '') ?></td>
                <td><?= htmlspecialchars($fields['quantity'] ?? '') ?></td>
                <td><?= htmlspecialchars($fields['dropoff'] ?? '') ?></td>
                <td><?= htmlspecialchars($fields['contact'] ?? '') ?></td>
                <td><?= htmlspecialchars($row['district']) ?></td>
                <td><?= htmlspecialchars($row['upazila']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <a href="respond_relief.php?request_id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Respond</a>
                    <a href="view_relief_responses.php?request_id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View Responses</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>