<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	if ($email === 'labinamehrin@gmail.com' && $password === '1234') {
		$_SESSION['is_admin'] = true;
		$success = true;
	} else {
		$error = 'Invalid email or password.';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body { background: #f7fafd; }
		.login-card {
			max-width: 370px;
			margin: 60px auto;
			background: #fff;
			border-radius: 18px;
			box-shadow: 0 8px 32px rgba(16,24,40,.10);
			padding: 2.2rem 2rem 1.5rem 2rem;
		}
	</style>
</head>
<body>
	<div class="login-card">
		<h3 class="text-center mb-4 fw-bold">Admin Login</h3>
		<?php if (!empty($success)): ?>
			<div class="alert alert-success mb-3">Login successful!</div>
			<form method="get" action="admin_manage_posts.php">
				<button type="submit" class="btn btn-success w-100">Go to Manage Posts</button>
			</form>
		<?php else: ?>
			<?php if ($error): ?>
				<div class="alert alert-danger mb-3"> <?= htmlspecialchars($error) ?> </div>
			<?php endif; ?>
			<form method="post">
				<div class="mb-3">
					<label for="email" class="form-label">Email</label>
					<input type="email" class="form-control" id="email" name="email" required autofocus>
				</div>
				<div class="mb-3">
					<label for="password" class="form-label">Password</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<button type="submit" class="btn btn-primary w-100">Login</button>
			</form>
		<?php endif; ?>
		<div class="mt-3 text-center">
			<a href="dashboard.php" class="text-decoration-none">&larr; Back to Dashboard</a>
		</div>
	</div>
</body>
</html>
