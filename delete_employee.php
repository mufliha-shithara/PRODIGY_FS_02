<?php

include 'includes/auth.php';
include 'includes/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: employees.php");
    exit();
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare(
    "DELETE FROM employees WHERE id = ?"
);

$stmt->bind_param("i", $id);

$stmt->execute();

$stmt->close();
$conn->close();

header("Location: employees.php");

exit();

?>