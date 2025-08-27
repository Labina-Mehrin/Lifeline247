<?php
session_start();
if (!isset($_SESSION['user_id'])) {
	header('Location: ../reg_log/login.php');
	exit();
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	include '../db_connect.php';
	$name = trim($conn->real_escape_string($_POST['name']));
	$location = trim($conn->real_escape_string($_POST['location']));
	$contact = trim($conn->real_escape_string($_POST['contact']));
	$features = trim($conn->real_escape_string($_POST['features']));
	$photo = '';
	if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
		$target_dir = "../uploads/";
		if (!is_dir($target_dir)) {
			mkdir($target_dir, 0777, true);
		}
		$ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
		$new_filename = uniqid('missing_', true) . '.' . $ext;
		$target_file = $target_dir . $new_filename;
		if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)) {
			$photo = $target_file;
		}
	}
	$sql = "INSERT INTO missing_persons (name, photo, location, contact, features, reported_by, reported_at) VALUES ('$name', '$photo', '$location', '$contact', '$features', '{$_SESSION['user_id']}', NOW())";
	if ($conn->query($sql) === TRUE) {
		$message = '<div class="alert alert-success">Missing person registered successfully!</div>';
	} else {
		$message = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Register Missing Person</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		body {
			background: #f4f6fb;
			min-height: 100vh;
		}
		.main-wrapper {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
		}
		.register-box {
			background: #fff;
			border-radius: 10px;
			box-shadow: 0 2px 12px rgba(0,0,0,0.07);
			width: 100%;
			max-width: 480px;
			padding: 2.5rem 2rem 2rem 2rem;
		}
		.register-title {
			font-size: 1.7rem;
			font-weight: 600;
			color: #0072ff;
			margin-bottom: 0.5rem;
			text-align: center;
		}
		.register-desc {
			color: #555;
			font-size: 1rem;
			text-align: center;
			margin-bottom: 1.5rem;
		}
		.form-label {
			font-weight: 500;
			color: #222;
		}
		.form-control, textarea {
			border-radius: 6px;
		}
		.btn-main {
			background: #0072ff;
			color: #fff;
			border: none;
			border-radius: 7px;
			font-weight: 600;
			font-size: 1rem;
		}
		.btn-main:hover {
			background: #0052cc;
		}
		.dashboard-link {
			display: block;
			text-align: middle;
			margin-bottom: 1rem;
		}
	</style>
</head>
<body>
<div class="main-wrapper">
	<div class="register-box">
		<a href="home_dashboard.php" class="dashboard-link btn btn-outline-primary btn-sm"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a>
		<div class="register-title"><i class="fa-solid fa-user-magnifying-glass me-2"></i>Register Missing Person</div>
		<div class="register-desc">Please fill in the details below to report a missing person.</div>
		<?php echo $message; ?>
		<form method="POST" enctype="multipart/form-data" autocomplete="off">
			<div class="mb-3">
				<label class="form-label">Full Name</label>
				<input type="text" name="name" class="form-control" required maxlength="100">
			</div>
			<div class="mb-3">
				<label class="form-label">Photo</label>
				<input type="file" name="photo" class="form-control" accept="image/*">
			</div>
			<div class="mb-3">
				<label class="form-label">Last Known Location</label>
				<input type="text" name="location" class="form-control" required maxlength="255">
			</div>
			<div class="mb-3">
				<label class="form-label">Contact Info</label>
				<input type="text" name="contact" class="form-control" required maxlength="100">
			</div>
			<div class="mb-3">
				<label class="form-label">Identifying Features</label>
				<textarea name="features" class="form-control" rows="3" required maxlength="500"></textarea>
			</div>
			<button type="submit" class="btn btn-main w-100 py-2">Register Missing Person</button>
		</form>
	</div>
</div>
</body>
</html>
