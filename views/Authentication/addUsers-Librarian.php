<?php

session_start();
$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showForm($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function showActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login-Register</title>
      <link rel="stylesheet" href="../assets/css/auth-Style/login-Register-Form.css">
</head>
<body>
    <div class="container">
        <!-- Register Form -->
        <div class="form-box <?= showActiveForm('register', $activeForm); ?>" id="register-form" style="display: block;">
            <form id="registerForm" action="login-Register.php" method="post" autocomplete="off" novalidate>
                <h2>📚 Library Management System</h2>
                <h3>Add New User</h3>
                <?= showForm($errors['register']); ?>
                <input type="text" name="name" id="name" placeholder="Name" required>
                <div class="error" id="nameError"></div>
                <input type="email" name="email" id="email" placeholder="Email" required>
                <div class="error" id="emailError"></div>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="error" id="passwordError"></div>
                <select name="role" id="role" required>
                    <option value="">Select Role</option>
                    <option value="student">Student</option>
                    <!-- <option value="librarian">Librarian</option> -->
                    <!-- <option value="admin">Admin</option> -->
                </select>
                <div class="error" id="roleError"></div>
                <button type="submit" name="register">Register</button>
            </form>
            <button style="background-color: #DC3C22;"
            onclick="window.location.href='../Dashboard/Admin/librarian-Dashboard.php'">Back</button>
            <p>Librarian Panel</p>
        </div>
    </div>

     <script src="../assets/app/auth-Script/login-Register-Form.js"></script>

</body>
</html>
