<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../config/db.php");

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? 'customer';

    if ($username === '' || $password === '') {
        $error = "All fields are required.";
    } else {

        // check duplicate username
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->execute([$username]);

        if ($check->fetch()) {
            $error = "Username already exists.";
        } else {

            // insert user
            $hashedPassword = md5($password);

            $insert = $conn->prepare("
                INSERT INTO users (username, password, role)
                VALUES (?, ?, ?)
            ");

            $insert->execute([$username, $hashedPassword, $role]);

            $success = "Account created successfully. You can now login.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="main">

    <h1>Create Account</h1>

    <!-- ERROR -->
    <?php if ($error): ?>
        <div class="login-error-box">❌ <?= $error ?></div>
    <?php endif; ?>

    <!-- SUCCESS -->
    <?php if ($success): ?>
        <div class="login-success-box">✅ <?= $success ?></div>
    <?php endif; ?>

    <!-- REGISTER FORM -->
    <div class="card" style="width:350px;">

        <form method="POST">

            <input name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>

            <select name="role">
                <option value="customer">Customer</option>
                <option value="employee">Employee</option>
            </select>

            <button name="register">Create Account</button>

        </form>

        <p style="margin-top:10px;">
            Already have an account?
            <a href="login.php">Login here</a>
        </p>

    </div>

</div>

</body>
</html>