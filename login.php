<?php

session_start();

include 'includes/db.php';

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {

        $error = "Please enter email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, full_name, email, password
             FROM admins
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $admin = $result->fetch_assoc();

            if (password_verify($password, $admin['password'])) {

                session_regenerate_id(true);

                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['full_name'];
                $_SESSION['admin_email'] = $admin['email'];

                header("Location: dashboard.php");
                exit();

            } else {

                $error = "Incorrect password.";

            }

        } else {

            $error = "No account found with this email.";

        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Login | Employee Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body class="login-page">

<div class="login-card">

<div class="login-icon">

<i class="bi bi-shield-lock-fill"></i>

</div>

<h2>Admin Login</h2>

<p class="text-muted">
Employee Management System
</p>

<?php if ($error != "") { ?>

<div class="alert alert-danger">
<i class="bi bi-exclamation-circle"></i>
<?php echo htmlspecialchars($error); ?>
</div>

<?php } ?>

<form method="POST">

<div class="mb-3">

<label class="form-label">Email Address</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-envelope"></i>
</span>

<input
type="email"
name="email"
class="form-control"
placeholder="Enter your email"
required>

</div>

</div>

<div class="mb-4">

<label class="form-label">Password</label>

<div class="input-group">

<span class="input-group-text">
<i class="bi bi-lock"></i>
</span>

<input
type="password"
id="password"
name="password"
class="form-control"
placeholder="Enter your password"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword()">

<i class="bi bi-eye" id="eyeIcon"></i>

</button>

</div>

</div>

<button
type="submit"
name="login"
class="btn btn-primary w-100 login-btn">

<i class="bi bi-box-arrow-in-right"></i>
Login

</button>

</form>

</div>

<script src="assets/js/script.js"></script>

</body>
</html>