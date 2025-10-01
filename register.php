<?php
session_start();
function check($inputUser, $csvPath = 'users.csv') {
    $handle = fopen($csvPath, 'r');
    if (!$handle) return false;
    $headers = fgetcsv($handle);
    while (($row = fgetcsv($handle)) !== false) {
        list($username, $password) = $row;
        if ($username === $inputUser) {
            fclose($handle);
            return false;
        }
    }
    fclose($handle);
    return true;
}

function addpass($addUser, $addPass, $csvPath = 'users.csv') {
    $handle = fopen($csvPath, 'a');
    if (!$handle) return false;
    $array = [$addUser,$addPass];
    fputcsv($handle, $array);
    fclose($handle);
    return true;
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (check($username)) {
        if (addpass($username, $password)) {
            $error = 'Account registered sucessfuly.';
            sleep(3);
            header("Location: login.php");
            exit;
        } else {
            $error = 'There was a problem with registering. Try again later.';
        }
    } else {
        $error = 'Username already in use.';
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
            <form action="register.php" method="post" id="login-form">
                <h2>Register</h2>
                <?php if (isset($error)) echo "<p style='color:#ff4d4d;'>$error</p>"; ?>
                <input class="login-form-input" type="text" name="set username" placeholder="Username" required><br>
                <input class="login-form-input" type="password" name="set password" placeholder="Password" required><br>
                <button class="login-form-button" type="submit">Register</button>
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </form>
        </div>
    </body>
</html>