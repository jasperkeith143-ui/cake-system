<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("../config/db.php");

if (isset($_POST['login'])) {

    $username = trim($_POST['username'] ?? '');
    $password = md5(trim($_POST['password'] ?? ''));

    // 🚫 VALIDATION
    if ($username === '' || $_POST['password'] === '') {
        $login_error = "Please fill in all fields.";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->execute([$username, $password]);

        $user = $stmt->fetch();

        if ($user) {

            // 🧹 ALWAYS RESET SESSION FIRST (VERY IMPORTANT)
         $role = strtolower(trim($user['role']));

$_SESSION['user'] = $user['username'];
$_SESSION['role'] = $role;

// 🔥 SAFE ROUTING
if ($role === 'admin') {
    header("Location: ../admin/dashboard.php");
    exit();
}

if ($role === 'employee') {
    header("Location: ../employee/dashboard.php");
    exit();
}

if ($role === 'customer') {
    header("Location: ../customer/dashboard.php");
    exit();
}

// fallback safety
header("Location: ../auth/login.php");
exit();

        } else {
            $login_error = "Invalid username or password.";
        }
    }
}
?>
<!-- ================= LOGIN UI ================= -->


<!DOCTYPE html>
<html>
<head>
    <title>Cake System - Login</title>
    <link rel="stylesheet" href="/cake-system/assets/style.css">
</head>
<body>

<!-- SIDEBAR (same as dashboard style) -->
<div class="main">

    <h1>Welcome Back 👋</h1>
    <p>Login to continue</p>

    <!-- LOGIN CARD -->
    <div class="card" style="width:350px;">

        <h3>Login</h3>

    <?php if (isset($_POST['login']) && isset($login_error)): ?>
        <div class="login-error-box">
            ❌ <?= $login_error ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <input name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button name="login">Login</button>
        </form>

        <!-- TOGGLE LINK -->
        <p class="toggle-text">
         <p>
    Don’t have an account?
    <a href="register.php">Create account</a>
</p>
        </p>

    </div>

    <!-- REGISTER CARD (HIDDEN FIRST) -->
    <div class="card register-card" id="registerCard">

        <h3>Create Account</h3>

        <form method="POST">
            <input name="reg_username" placeholder="Username" required><br>
            <input type="password" name="reg_password" placeholder="Password" required><br>

            <select name="role">
                <option value="customer">Customer</option>
                <option value="employee">Employee</option>
            </select>

            <button name="register">Create Account</button>
        </form>

    </div>

</div>
    </div>

</div>

<script src="/cake-system/assets/script.js"></script>
</body>
</html>
