<?php
<?php
require_once '../db_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $age = trim($_POST['age']);
    $last_seen = trim($_POST['last_seen']);
    $last_seen_date = trim($_POST['last_seen_date']);
    $reporter_name = trim($_POST['reporter_name']);
    $reporter_email = trim($_POST['reporter_email']);
    $reporter_phone = trim($_POST['reporter_phone']);
    $image_path = '';
    $sms_opt_in = isset($_POST['sms_opt_in']) ? 1 : 0;

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "../uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $filename = uniqid() . '_' . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $filename;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = "uploads/" . $filename;
        }
    }

    // Insert into database (add reporter info and age)
    $stmt = $conn->prepare("INSERT INTO missing_persons (name, age, last_seen, last_seen_date, image_path, status, reporter_name, reporter_email, reporter_phone, sms_opt_in) VALUES (?, ?, ?, ?, ?, 'missing', ?, ?, ?, ?)");
    $stmt->bind_param("sisssssssi", $name, $age, $last_seen, $last_seen_date, $image_path, $reporter_name, $reporter_email, $reporter_phone, $sms_opt_in);
    if ($stmt->execute()) {
        $case_id = $stmt->insert_id;
        $message = "Missing person registered successfully!<br><strong>Case ID: #$case_id</strong>";
    } else {
        $message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Missing Person</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Register Missing Person</h3>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Name of Missing Person</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Seen Location</label>
            <input type="text" name="last_seen" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Seen Date</label>
            <input type="date" name="last_seen_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload Photo</label>
            <input type="file" name="image" class="form-control">
        </div>
        <hr>
        <h5 class="mt-4 mb-3">Reporter Registration</h5>
        <div class="mb-3">
            <label class="form-label">Your Name</label>
            <input type="text" name="reporter_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Email</label>
            <input type="email" name="reporter_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Your Phone Number</label>
            <input type="text" name="reporter_phone" class="form-control" required>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="sms_opt_in" id="sms_opt_in" value="1">
            <label class="form-check-label" for="sms_opt_in">Notify me via SMS for status updates</label>
        </div>
            <input type="date" name="last_seen_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type=