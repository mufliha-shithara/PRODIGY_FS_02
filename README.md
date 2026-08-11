# Employee Management System

A web-based Employee Management System developed as part of the Prodigy InfoTech Full-Stack Web Development Internship - Task 02.

## 1. Project Overview

This system allows administrators to manage employee records securely.

Administrators can:

* Add employees
* View employees
* Search employees
* Update employee details
* Delete employee records

## 2. Internship Details

* Organization: Prodigy InfoTech
* Track: Full-Stack Web Development
* Track Code: FS
* Task: Task-02
* Task Title: Employee Management System

## 3. Features

* Admin Login
* Password Hashing
* Session Authentication
* Employee CRUD Operations
* Search Employees
* Form Validation
* Email Validation
* Prepared Statements
* Responsive UI
* Admin Dashboard
* Active/Inactive Employee Status

## 4. Technologies Used

* HTML5
* CSS3
* JavaScript
* PHP
* MySQL
* Bootstrap 5
* XAMPP

## 5. CRUD Operations

| Operation | File                | Description               |
| --------- | ------------------- | ------------------------- |
| Create    | add_employee.php    | Add employee              |
| Read      | employees.php       | View and search employees |
| Update    | edit_employee.php   | Update employee           |
| Delete    | delete_employee.php | Delete employee           |

## 6. Security

* Passwords are protected using `password_hash()`.
* Passwords are verified using `password_verify()`.
* Session authentication protects admin pages.
* Prepared statements are used for database queries.
* User input is validated.
* Output is protected using `htmlspecialchars()`.

## 7. Database

MySQL is used as the database.

Main tables:

* `admins`
* `employees`

## 8. Installation

1. Install XAMPP.
2. Start Apache and MySQL.
3. Place the project inside `xampp/htdocs/`.
4. Open phpMyAdmin.
5. Create the `prodigy_fs02` database.
6. Import `database.sql`.
7. Configure `includes/db.php`.
8. Open the project in your browser:

```text
http://localhost/PRODIGY_FS_02/
```

## 9. Screenshots

Add screenshots of:

1. Admin Login
2. Dashboard
3. Employee Management
4. Add Employee
5. Edit Employee

## 10. What I Learned

* PHP and MySQL CRUD operations
* Authentication and session management
* Password hashing
* Form validation
* Prepared statements
* Responsive UI development
* Git and GitHub

## 11. Developer

Mohamed Uwais Fathima Mufliha

Full-Stack Web Development Intern

Prodigy InfoTech

## 12. Internship

This project was developed as part of the Prodigy InfoTech Full-Stack Web Development Internship Program.
