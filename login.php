<?php
session_start();
include 'db_connect.php';

$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $connection = createDbConnection();

    $stmt = $connection->prepare("SELECT * FROM users WHERE userName = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $storedUser = $result->fetch_assoc();
        $storedPassword = $storedUser['password'];
        $storedSalt = $storedUser['salt'];
        $currentHashedPassword = hash('sha256', ($storedSalt . $password));

        if ($storedPassword == $currentHashedPassword) {
            $_SESSION['isnewuser'] = false;
            $_SESSION['username'] = $username;
            header("Location: feed.php");
            exit;
        }
    }

    $message = "The input credentials either don't exist, or are wrong. Please try again.";
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php if ($message): ?>
        <div class="alert alert-danger" role="alert">
            <?= $message ?>
        </div>
    <?php endif; ?>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <p>Don't have an account? <a href="sign_up.php">Sign-up instead</a></p>
</div>
</body>
</html>