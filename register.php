<?php
session_start();
function register($inputUser, $inputPass, $csvPath = 'users.csv') {
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
        <title>Login - ProjectMe</title>
        <link rel="stylesheet" href="styles.css">
        <link rel="icon" type="image/png" href="favicon.png">
    </head>
    <body>
        <div class="login-div">
            <form action="register.php" method="post" id="login-form">
                <h2>Register</h2>
                <input class="login-form-input" type="text" name="set username" placeholder="Username" required><br>
                <input class="login-form-input" type="password" name="set password" placeholder="Password" required><br>
                <button class="login-form-button" type="submit">Register</button>
                <p>Already have an account? <a href="login.html">Login here</a></p>
            </form>
        </div>
    </body>
</html>