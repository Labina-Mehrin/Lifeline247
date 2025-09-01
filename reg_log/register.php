<?php
include '../db_connect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : 'family';

    // Check for duplicate email
    $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
    if ($check->num_rows > 0) {
        $message = '<div class="alert alert-danger">Email already registered!</div>';
    } else {
        $sql = "INSERT INTO users (name, email, password, role, created_at) VALUES ('$name', '$email', '$password', '$role', NOW())";
        if ($conn->query($sql) === TRUE) {
            // Auto-login after registration (as shrr sir wanted)
            $user_id = $conn->insert_id;
            session_start();
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_role'] = $role;
            header('Location: ../dashboard/home_dashboard.php');
            exit();
        } else {
            $message = '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            min-height: 100vh;
        }
        .register-card {
            border-radius: 18px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(90deg, #0072ff 0%, #00c6ff 100%);
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
            color: #0072ff;
        }
        .card-body {
            padding: 2rem;
        }
        .btn-primary {
            background: linear-gradient(90deg, #0072ff 0%, #00c6ff 100%);
            border: none;
            border-radius: 10px;
            font-weight: 600;
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #0052cc 0%, #0099cc 100%);
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="register-card">
                <div class="register-header">
                    <!-- <h3 class="mb-0"><i class="fa-solid fa-user-plus me-2"></i>Sign Up</h3> -->
                    <p class="mb-0" style="font-size: 1rem;">Open new account</p>
                </div>
                <div class="card-body">
                    <?php echo $message; ?>
                    <form method="POST" action="">
                        <div class="mb-4 position-relative">
                            <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                        </div>
                        <div class="mb-4 position-rselative">
                            <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="mb-4 position-relative">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="mb-4 position-relative">
                            <span class="input-icon"><i class="fa-solid fa-user-tag"></i></span>
                            <select name="role" class="form-control" required>
                                <option value="">Select Role</option>
                                <option value="family">Family Member</option>
                                <option value="hospital">Hospital Staff</option>
                                <option value="rescue">Rescue Team</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                    </form>
					<div class="login-link">
						<a href="login.php">Already have an account? Login here</a>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>