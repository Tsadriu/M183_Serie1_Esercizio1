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

    if ($result->num_rows == 0) {
        $hashedPassword = hash('sha256', $password);
        // Clean input to prevent sql injection
        $statement = $connection->prepare("INSERT INTO users(userName, password, creationDateTime) VALUES (?, ?, ?)");
        $dateTime = date('Y-m-d H:i:s');
        $statement->bind_param("sss", $username, $hashedPassword, $dateTime);
        $statement->execute();

        // Start session for the user and redirect them to feed.php
        $_SESSION['username'] = $username;
        $_SESSION['isnewuser'] = true;
        $_SESSION['message'] = "Account created successfully!";
        header('Location: feed.php');

        $statement->close();
    } else {
        $message = "Username is already taken. Please choose another username.";
    }

    $connection->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php if (!empty($message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>
    <form action="sign_up.php" method="post">
        <div class="form-group">
            <h2>Create your account!</h2>
            <label for="username">Username:</label><br/>
            <input type="text" class="form-control" id="username" name="username" required><br/>
            <label for="password">Password:</label><br/>
            <input type="password" class="form-control" id="password" name="password" required><br/>
            <button type="submit" class="btn btn-primary">Sign up</button>
        </div>
    </form>
    <p>Already have an account? <a href="login.php">Login instead</a></p>
</div>
</body>
</html>
