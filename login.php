<?php
session_start();
function authenticate($inputUser, $inputPass, $csvPath = 'users.csv') {
    $handle = fopen($csvPath, 'r');
    if (!$handle) return false;
    $headers = fgetcsv($handle);
    while (($row = fgetcsv($handle)) !== false) {
        list($username, $password) = $row;
        if (($username === $inputUser) && ($inputPass === $password)) {
            fclose($handle);
            return true;
        }
    }
    fclose($handle);
    return false;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (authenticate($username, $password)) {
        $_SESSION['user'] = $username;
        header("Location: dashboard.html");
        exit;
    } else {
        $error = 'Failed to login. Incorrect username or password.';
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Presently</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="icon" type="image/png" href="favicon.png">
    </head>
    <body>
        <div class="login-div">
            <form action="login.php" method="POST" id="login-form">
                <h2>Login</h2>
                <?php if (isset($error)) echo "<p style='color:#ff4d4d;'>$error</p>"; ?>
                <input class="login-form-input" type="text" name="username" placeholder="Username" required><br>
                <input class="login-form-input" type="password" name="password" placeholder="Password" required><br>
                <button class="login-form-button" type="submit">Login</button>
                <p>Don't have an account? <a href="register.php">Register here</a></p>
                <p>Want to recover your account? Ask me in person: Jon Ort.</p>
            </form>
        </div>
    </body>
</html>