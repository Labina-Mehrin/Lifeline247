<?php
include '../db_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = $conn->real_escape_string($_POST['email']);
	$password = $_POST['password'];
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = $conn->query($sql);
	if ($result->num_rows == 1) {
		$user = $result->fetch_assoc();
		if (password_verify($password, $user['password'])) {
			// Login success, start session
			session_start();
			$_SESSION['user_id'] = $user['id'];
			$_SESSION['user_name'] = $user['name'];
			$_SESSION['user_role'] = $user['role'];
			header('Location: ../dashboard/home_dashboard.php');
			exit();
		} else {
			$message = '<div class="alert alert-danger">Invalid password.</div>';
		}
	} else {
		$message = '<div class="alert alert-danger">No account found with that email.</div>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<style>
		body {
			background: linear-gradient(135deg, #f8ffae 0%, #43c6ac 100%);
			min-height: 100vh;
		}
		.login-card {
			border-radius: 18px;
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
			overflow: hidden;
		}
		.login-header {
			background: linear-gradient(90deg, #43c6ac 0%, #191654 100%);
			color: #fff;
			padding: 2rem 1rem 1rem 1rem;
			text-align: center;
		}
		.form-control {
			border-radius: 10px;
			padding-left: 2.5rem;
		}
		.input-icon {
			position: absolute;
			left: 15px;
			top: 50%;
			transform: translateY(-50%);
			color: #43c6ac;
		}
		.card-body {
			padding: 2rem;
		}
		.btn-primary {
			background: linear-gradient(90deg, #43c6ac 0%, #191654 100%);
			border: none;
			border-radius: 10px;
			font-weight: 600;
		}
		.btn-primary:hover {
			background: linear-gradient(90deg, #2e8b8b 0%, #191654 100%);
		}
		.register-link {
			text-align: center;
			margin-top: 1rem;
		}
	</style>
</head>
<body>
<div class="container py-5">
	<div class="row justify-content-center">
		<div class="col-md-6 col-lg-5">
			<div class="login-card">
				<div class="login-header">
					<!-- <h3 class="mb-0"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</h3> -->
					<p class="mb-0" style="font-size: 1rem;">Login here</p>
				</div>
				<div class="card-body">
					<?php echo $message; ?>
					<form method="POST" action="">
						<div class="mb-4 position-relative">
							<span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
							<input type="email" name="email" class="form-control" placeholder="Email Address" required>
						</div>
						<div class="mb-4 position-relative">
							<span class="input-icon"><i class="fa-solid fa-lock"></i></span>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<button type="submit" class="btn btn-primary w-100 py-2">Login</button>
					</form>
					<div class="register-link">
						<a href="register.php">Don't have an account? Register here</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
