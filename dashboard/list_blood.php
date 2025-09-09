<?php
require_once '../db_connect.php';

// Build SQL query with filters
$conditions = ["type='BLOOD'"];
if (!empty($_GET['blood_group'])) {
    $bg = $conn->real_escape_string($_GET['blood_group']);
    $conditions[] = "JSON_UNQUOTE(JSON_EXTRACT(fields_json, '$.blood_group')) = '$bg'";
}
if (!empty($_GET['district'])) {
    $district = $conn->real_escape_string($_GET['district']);
    $conditions[] = "district = '$district'";
}
if (!empty($_GET['status'])) {
    $status = $conn->real_escape_string($_GET['status']);
    $conditions[] = "status = '$status'";
}
$where = implode(' AND ', $conditions);
$sql = "SELECT * FROM requests WHERE $where ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="container mt-4">
    <h3>All Blood Requests</h3>
    <form method="get" class="row g-3 mb-3">
        <div class="col-md-3">
            <input type="text" name="blood_group" class="form-control" placeholder="Blood Group" value="<?= isset($_GET['blood_group']) ? htmlspecialchars($_GET['blood_group']) : '' ?>">
        </div>
        <div class="col-md-3">
            <input type="text" name="district" class="form-control" placeholder="District" value="<?= isset($_GET['district']) ? htmlspecialchars($_GET['district']) : '' ?>">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="OPEN" <?= (isset($_GET['status']) && $_GET['status']=='OPEN') ? 'selected' : '' ?>>Open</option>
                <option value="MATCHED" <?= (isset($_GET['status']) && $_GET['status']=='MATCHED') ? 'selected' : '' ?>>Matched</option>
                <option value="FULFILLED" <?= (isset($_GET['status']) && $_GET['status']=='FULFILLED') ? 'selected' : '' ?>>Fulfilled</option>
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
    </form>
    <table class="table table-bordered table-striped mt-3">
        <thead>
            <tr>
                <th>Blood Group</th>
                <th>Units</th>
                <th>Facility</th>
                <th>Urgency</th>
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
                <td><?= htmlspecialchars($fields['blood_group']) ?></td>
                <td><?= htmlspecialchars($fields['units']) ?></td>
                <td><?= htmlspecialchars($fields['facility']) ?></td>
                <td><?= htmlspecialchars($fields['urgency']) ?></td>
                <td><?= htmlspecialchars($fields['contact']) ?></td>
                <td><?= htmlspecialchars($row['district']) ?></td>
                <td><?= htmlspecialchars($row['upazila']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['created_at']) ?></td>
                <td>
                    <a href="respond_blood.php?request_id=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Respond</a>
                    <a href="view_blood_responses.php?request_id=<?= $row['id'] ?>" class="btn btn-sm btn-info">View Responses</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>