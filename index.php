<!DOCTYPE html>
<html lang="en">
<head>
	<title>LifeLine for the Missing</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	 -->
    <style>
		body {
			background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
			min-height: 100vh;
		}
		.center-card {
			border-radius: 18px;
			box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
			overflow: hidden;
			margin-top: 8vh;
		}
		.card-header {
			background: linear-gradient(90deg, #0072ff 0%, #00c6ff 100%);
			color: #fff;
			text-align: center;
			padding: 2rem 1rem 1rem 1rem;
		}
		.btn-lg {
			border-radius: 10px;
			font-weight: 600;
			font-size: 1.2rem;
			margin-bottom: 1rem;
		}
		.btn-register {
			background: linear-gradient(90deg, #43c6ac 0%, #191654 100%);
			color: #fff;
			border: none;
		}
		.btn-register:hover {
			background: linear-gradient(90deg, #2e8b8b 0%, #191654 100%);
		}
		.btn-login {
			background: linear-gradient(90deg, #0072ff 0%, #00c6ff 100%);
			color: #fff;
			border: none;
		}
		.btn-login:hover {
			background: linear-gradient(90deg, #0052cc 0%, #0099cc 100%);
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-7 col-lg-6">
			<div class="card center-card">
				<div class="card-header">
					<h2><i class="fa-solid fa-life-ring me-2"></i>LifeLine for the Missing</h2>
					<p class="mb-0" style="font-size: 1.1rem;">A platform to help families, rescue teams, and authorities find and support missing persons during disasters.</p>
				</div>
				<div class="card-body text-center py-5">
					<a href="reg_log/register.php" class="btn btn-register btn-lg w-75 mb-3"><i class="fa-solid fa-user-plus me-2"></i>Register</a>
					<a href="reg_log/login.php" class="btn btn-login btn-lg w-75"><i class="fa-solid fa-right-to-bracket me-2"></i>Login</a>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
