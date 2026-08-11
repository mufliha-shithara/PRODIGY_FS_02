<?php

include 'includes/auth.php';
include 'includes/db.php';

$search = "";

if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

if ($search != "") {

    $stmt = $conn->prepare(
        "SELECT *
         FROM employees
         WHERE employee_id LIKE ?
         OR full_name LIKE ?
         OR email LIKE ?
         OR department LIKE ?
         ORDER BY id DESC"
    );

    $term = "%" . $search . "%";

    $stmt->bind_param(
        "ssss",
        $term,
        $term,
        $term,
        $term
    );

    $stmt->execute();

    $employees = $stmt->get_result();

} else {

    $employees = $conn->query(
        "SELECT *
         FROM employees
         ORDER BY id DESC"
    );

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Employees</title>

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

<h3>Employees</h3>

<p>Manage employee records</p>

</div>

<a href="add_employee.php"
class="btn btn-primary">

<i class="bi bi-person-plus"></i>
Add Employee

</a>

</div>

<div class="content-card">

<form method="GET" class="search-form mb-4">

<div class="input-group">

<input
type="text"
name="search"
class="form-control"
placeholder="Search by ID, name, email or department..."
value="<?php echo htmlspecialchars($search); ?>">

<button class="btn btn-primary">

<i class="bi bi-search"></i>
Search

</button>

<?php if ($search != "") { ?>

<a href="employees.php"
class="btn btn-outline-secondary">

Clear

</a>

<?php } ?>

</div>

</form>

<div class="table-responsive">

<table class="table align-middle">

<thead>

<tr>

<th>Employee ID</th>
<th>Name</th>
<th>Email</th>
<th>Department</th>
<th>Position</th>
<th>Status</th>
<th>Actions</th>

</tr>

</thead>

<tbody>

<?php if ($employees && $employees->num_rows > 0) { ?>

<?php while ($employee = $employees->fetch_assoc()) { ?>

<tr>

<td>
<strong>
<?php echo htmlspecialchars($employee['employee_id']); ?>
</strong>
</td>

<td>
<?php echo htmlspecialchars($employee['full_name']); ?>
</td>

<td>
<?php echo htmlspecialchars($employee['email']); ?>
</td>

<td>
<?php echo htmlspecialchars($employee['department']); ?>
</td>

<td>
<?php echo htmlspecialchars($employee['position']); ?>
</td>

<td>

<?php if ($employee['status'] == "Active") { ?>

<span class="badge bg-success-subtle text-success">
Active
</span>

<?php } else { ?>

<span class="badge bg-danger-subtle text-danger">
Inactive
</span>

<?php } ?>

</td>

<td>

<a href="edit_employee.php?id=<?php echo $employee['id']; ?>"
class="btn btn-sm btn-outline-primary">

<i class="bi bi-pencil"></i>

</a>

<a href="delete_employee.php?id=<?php echo $employee['id']; ?>"
class="btn btn-sm btn-outline-danger"
onclick="return confirm('Are you sure you want to delete this employee?');">

<i class="bi bi-trash"></i>

</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="7" class="text-center py-5">

<i class="bi bi-people display-6 text-muted"></i>

<p class="mt-3 mb-0">
No employees found.
</p>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</main>

</div>

</body>
</html>