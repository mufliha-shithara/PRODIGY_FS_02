<?php

include 'includes/auth.php';
include 'includes/db.php';

$totalEmployees = 0;
$activeEmployees = 0;
$inactiveEmployees = 0;
$totalDepartments = 0;

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM employees"
);

if ($result) {
    $row = $result->fetch_assoc();
    $totalEmployees = $row['total'];
}

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE status = 'Active'"
);

if ($result) {
    $row = $result->fetch_assoc();
    $activeEmployees = $row['total'];
}

$result = $conn->query(
    "SELECT COUNT(*) AS total
     FROM employees
     WHERE status = 'Inactive'"
);

if ($result) {
    $row = $result->fetch_assoc();
    $inactiveEmployees = $row['total'];
}

$result = $conn->query(
    "SELECT COUNT(DISTINCT department) AS total
     FROM employees"
);

if ($result) {
    $row = $result->fetch_assoc();
    $totalDepartments = $row['total'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<title>Dashboard | Employee Management</title>

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

<a href="dashboard.php" class="active">
<i class="bi bi-grid"></i>
Dashboard
</a>

<a href="employees.php">
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

<h3>Dashboard</h3>

<p>
Welcome back,
<strong>
<?php echo htmlspecialchars($_SESSION['admin_name']); ?>
</strong> 👋
</p>

</div>

<div class="date-box">

<i class="bi bi-calendar3"></i>

<?php echo date("d M Y"); ?>

</div>

</div>

<div class="row g-4">

<div class="col-md-6 col-xl-3">

<div class="stat-card">

<div class="stat-icon purple">
<i class="bi bi-people-fill"></i>
</div>

<div>

<span>Total Employees</span>

<h3><?php echo $totalEmployees; ?></h3>

</div>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card">

<div class="stat-icon green">
<i class="bi bi-person-check-fill"></i>
</div>

<div>

<span>Active</span>

<h3><?php echo $activeEmployees; ?></h3>

</div>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card">

<div class="stat-icon red">
<i class="bi bi-person-x-fill"></i>
</div>

<div>

<span>Inactive</span>

<h3><?php echo $inactiveEmployees; ?></h3>

</div>

</div>

</div>

<div class="col-md-6 col-xl-3">

<div class="stat-card">

<div class="stat-icon blue">
<i class="bi bi-diagram-3-fill"></i>
</div>

<div>

<span>Departments</span>

<h3><?php echo $totalDepartments; ?></h3>

</div>

</div>

</div>

</div>

<div class="welcome-card mt-4">

<div>

<h4>Employee Management System</h4>

<p>
Manage employee records, departments and employment status from one place.
</p>

<a href="employees.php"
class="btn btn-primary">

<i class="bi bi-people"></i>
View Employees

</a>

<a href="add_employee.php"
class="btn btn-outline-primary">

<i class="bi bi-person-plus"></i>
Add Employee

</a>

</div>

<i class="bi bi-building display-icon"></i>

</div>

</main>

</div>

</body>
</html>