<?php
 
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../reg_log/login.php');
    exit();
}

// Only hospital staff can update missing person data
if ($_SESSION['user_role'] !== 'hospital') {
    echo '<div class="alert alert-danger">Access denied. Only hospital staff can update missing person data.</div>';
    exit();
}

include '../db_connect.php';

// Get missing person ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo '<div class="alert alert-danger">Invalid missing person ID.</div>';
    exit();
}

// Fetch existing data
$result = $conn->query("SELECT * FROM missing_persons WHERE id = $id");
if ($result->num_rows !== 1) {
    echo '<div class="alert alert-danger">Missing person not found.</div>';
    exit();
}
$row = $result->fetch_assoc();

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $location = $conn->real_escape_string($_POST['location']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $features = $conn->real_escape_string($_POST['features']);

    $update = $conn->query("UPDATE missing_persons SET name='$name', location='$location', contact='$contact', features='$features' WHERE id=$id");
    if ($update) {
        $message = '<div class="alert alert-success">Missing person data updated successfully.</div>';
        // Optionally, refresh data
        $row = array_merge($row, ['name'=>$name, 'location'=>$location, 'contact'=>$contact, 'features'=>$features]);
    } else {
        $message = '<div class="alert alert-danger">Update failed: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Missing Person</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2>Update Missing Person</h2>
    <a href="search_missing.php" class="btn btn-secondary mb-3">&larr; Back to Search</a>
    <?php echo $message; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($row['location']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" class="form-control" value="<?php echo htmlspecialchars($row['contact']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Features</label>
            <textarea name="features" class="form-control" required><?php echo htmlspecialchars($row['features']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>