<?php

include 'includes/auth.php';
include 'includes/db.php';

$error = "";

if (isset($_POST['add_employee'])) {

    $employee_id = trim($_POST['employee_id']);
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $department = trim($_POST['department']);
    $position = trim($_POST['position']);
    $salary = trim($_POST['salary']);
    $joining_date = $_POST['joining_date'];
    $status = $_POST['status'];

    if (
        empty($employee_id) ||
        empty($full_name) ||
        empty($email) ||
        empty($department) ||
        empty($position) ||
        empty($joining_date)
    ) {

        $error = "Please fill all required fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO employees
            (employee_id, full_name, email, phone, department, position, salary, joining_date, status)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssssssdss",
            $employee_id,
            $full_name,
            $email,
            $phone,
            $department,
            $position,
            $salary,
            $joining_date,
            $status
        );

        if ($stmt->execute()) {

            header("Location: employees.php");
            exit();

        } else {

            if ($stmt->errno == 1062) {
                $error = "Employee ID or Email already exists.";
            } else {
                $error = "Unable to add employee.";
            }

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

<title>Add Employee</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="dashboard-wrapper">

<aside class="sidebar">

<div class="brand">
<i class="bi bi-building"></i>
EmployeeMS
</div>

<div class="admin-info">

<div class="admin-avatar">
<i class="bi bi-person"></i>
</div>

<div>
<strong>
<?php echo htmlspecialchars($_SESSION['admin_name']); ?>
</strong>
<small>Administrator</small>
</div>

</div>

<nav>

<a href="dashboard.php">
<i class="bi bi-grid"></i>
Dashboard
</a>

<a href="employees.php">
<i class="bi bi-people"></i>
Employees
</a>

<a href="add_employee.php" class="active">
<i class="bi bi-person-plus"></i>
Add Employee
</a>

<a href="logout.php" class="logout-link">
<i class="bi bi-box-arrow-right"></i>
Logout
</a>

</nav>

</aside>

<main class="main-content">

<div class="topbar">

<div>

<h3>Add Employee</h3>

<p>Create a new employee record</p>

</div>

</div>

<div class="content-card">

<?php if ($error != "") { ?>

<div class="alert alert-danger">

<i class="bi bi-exclamation-circle"></i>

<?php echo htmlspecialchars($error); ?>

</div>

<?php } ?>

<form method="POST">

<div class="row g-3">

<div class="col-md-6">

<label class="form-label">
Employee ID *
</label>

<input
type="text"
name="employee_id"
class="form-control"
placeholder="EMP001"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Full Name *
</label>

<input
type="text"
name="full_name"
class="form-control"
placeholder="Enter full name"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Email *
</label>

<input
type="email"
name="email"
class="form-control"
placeholder="employee@example.com"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Phone
</label>

<input
type="text"
name="phone"
class="form-control"
placeholder="0771234567">

</div>

<div class="col-md-6">

<label class="form-label">
Department *
</label>

<select name="department"
class="form-select"
required>

<option value="">Select Department</option>

<option>IT</option>
<option>HR</option>
<option>Finance</option>
<option>Marketing</option>
<option>Sales</option>
<option>Operations</option>

</select>

</div>

<div class="col-md-6">

<label class="form-label">
Position *
</label>

<input
type="text"
name="position"
class="form-control"
placeholder="Software Developer"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Salary
</label>

<input
type="number"
step="0.01"
name="salary"
class="form-control"
placeholder="0.00">

</div>

<div class="col-md-6">

<label class="form-label">
Joining Date *
</label>

<input
type="date"
name="joining_date"
class="form-control"
required>

</div>

<div class="col-md-6">

<label class="form-label">
Status
</label>

<select name="status"
class="form-select">

<option value="Active">Active</option>
<option value="Inactive">Inactive</option>

</select>

</div>

</div>

<div class="mt-4">

<button
type="submit"
name="add_employee"
class="btn btn-primary">

<i class="bi bi-check-circle"></i>
Save Employee

</button>

<a href="employees.php"
class="btn btn-outline-secondary">

Cancel

</a>

</div>

</form>

</div>

</main>

</div>

</body>
</html>