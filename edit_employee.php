<?php

include 'includes/auth.php';
include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: employees.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare(
    "SELECT * FROM employees WHERE id = ?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: employees.php");
    exit();
}

$employee = $result->fetch_assoc();

$error = "";

if (isset($_POST['update_employee'])) {

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

        $update = $conn->prepare(
            "UPDATE employees
             SET employee_id = ?,
                 full_name = ?,
                 email = ?,
                 phone = ?,
                 department = ?,
                 position = ?,
                 salary = ?,
                 joining_date = ?,
                 status = ?
             WHERE id = ?"
        );

        $update->bind_param(
            "ssssssdssi",
            $employee_id,
            $full_name,
            $email,
            $phone,
            $department,
            $position,
            $salary,
            $joining_date,
            $status,
            $id
        );

        if ($update->execute()) {

            header("Location: employees.php");
            exit();

        } else {

            if ($update->errno == 1062) {
                $error = "Employee ID or Email already exists.";
            } else {
                $error = "Unable to update employee.";
            }

        }

        $update->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Edit Employee</title>

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

<a href="employees.php" class="active">
<i class="bi bi-people"></i>
Employees
</a>

<a href="add_employee.php">
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

<h3>Edit Employee</h3>

<p>Update employee information</p>

</div>

</div>

<div class="content-card">

<?php if ($error != "") { ?>

<div class="alert alert-danger">

<?php echo htmlspecialchars($error); ?>

</div>

<?php } ?>

<form method="POST">

<div class="row g-3">

<div class="col-md-6">

<label class="form-label">Employee ID *</label>

<input
type="text"
name="employee_id"
class="form-control"
value="<?php echo htmlspecialchars($employee['employee_id']); ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Full Name *</label>

<input
type="text"
name="full_name"
class="form-control"
value="<?php echo htmlspecialchars($employee['full_name']); ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Email *</label>

<input
type="email"
name="email"
class="form-control"
value="<?php echo htmlspecialchars($employee['email']); ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Phone</label>

<input
type="text"
name="phone"
class="form-control"
value="<?php echo htmlspecialchars($employee['phone']); ?>">

</div>

<div class="col-md-6">

<label class="form-label">Department *</label>

<select name="department"
class="form-select"
required>

<option value="">Select Department</option>

<?php

$departments = [
    "IT",
    "HR",
    "Finance",
    "Marketing",
    "Sales",
    "Operations"
];

foreach ($departments as $dept) {

    $selected = ($employee['department'] == $dept)
        ? "selected"
        : "";

    echo "<option value=\"$dept\" $selected>$dept</option>";
}

?>

</select>

</div>

<div class="col-md-6">

<label class="form-label">Position *</label>

<input
type="text"
name="position"
class="form-control"
value="<?php echo htmlspecialchars($employee['position']); ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Salary</label>

<input
type="number"
step="0.01"
name="salary"
class="form-control"
value="<?php echo htmlspecialchars($employee['salary']); ?>">

</div>

<div class="col-md-6">

<label class="form-label">Joining Date *</label>

<input
type="date"
name="joining_date"
class="form-control"
value="<?php echo htmlspecialchars($employee['joining_date']); ?>"
required>

</div>

<div class="col-md-6">

<label class="form-label">Status</label>

<select name="status"
class="form-select">

<option value="Active"
<?php echo $employee['status'] == 'Active' ? 'selected' : ''; ?>>
Active
</option>

<option value="Inactive"
<?php echo $employee['status'] == 'Inactive' ? 'selected' : ''; ?>>
Inactive
</option>

</select>

</div>

</div>

<div class="mt-4">

<button
type="submit"
name="update_employee"
class="btn btn-primary">

<i class="bi bi-save"></i>
Update Employee

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