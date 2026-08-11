<?php

include 'includes/db.php';

$name = "Admin";
$email = "admin@gmail.com";
$password = "Admin@123";

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $conn->prepare(
    "INSERT INTO admins (full_name, email, password)
     VALUES (?, ?, ?)"
);

$stmt->bind_param(
    "sss",
    $name,
    $email,
    $hashedPassword
);

if ($stmt->execute()) {
    echo "Admin created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>