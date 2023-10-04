<!DOCTYPE html>
<html lang="en">
<head>
    <title>Feed</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success'>";
    echo $_SESSION['message'];
    echo "</div>";
    unset($_SESSION['message']);
}
?>
<div class="container">
    <h2><?php
        if ($_SESSION['isnewuser']) {
            echo "Welcome to the website " . $_SESSION['username'] . "!";
        } else {
            echo "Welcome back, " . $_SESSION['username'];
        }
        ?></h2>
    <form action="feed.php" method="post">
        <div class="form-group">
            <label for="post">Write a post:</label>
            <input type="text" class="form-control" id="post" name="post" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button onclick="location.reload();" type="button" class="btn btn-primary">Refresh</button>
        <button type="button" onclick="window.location.href='logout.php'" class="btn btn-danger float-right">Logout</button>
    </form>
    <br/>

    <?php
    include 'db_connect.php';

    $conn = createDbConnection();
    $username = $_SESSION['username'];

    //Controlla se l'utente sta cercando di postare qualcosa
    if (isset($_POST['post'])) {
        $post = $_POST['post'];
        $dateTime = date('Y-m-d H:i:s');
        //inserisci il post nel database
        $sql = "INSERT INTO userposts (userId, post, postCreationDate)
                VALUES (" . $_SESSION["userid"] . ", '$post', '$dateTime')";

        if ($conn->query($sql) === TRUE) {
            echo "<p class='success'>Post created successfully</p>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Redirect to the same page (refresh btn)
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }

    //Seleziona tutti i post dell'utente
    $sql = "SELECT userposts.*, users.userName as username
            FROM userposts
            JOIN users ON userposts.userId = users.Id
            ORDER BY postCreationDate DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $encodedUsername = htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8');
            $encodedPost = htmlspecialchars($row['post'], ENT_QUOTES, 'UTF-8');
            $date = new DateTime($row['postCreationDate']);
            $formattedDate = $date->format('Y-m-d H:i');
            $fullDate = $date->format('Y-m-d H:i:s');

            echo "<div class='post'>
            <div class='post-header'>
                <span class='date-time' title='$fullDate'>" . $formattedDate . "</span>
                <span class='username'>" . $encodedUsername . "</span>
            </div>
            <div class='post-content'>" . $encodedPost . "</div>
          </div>";
        }
    } else {
        echo "<p class='warning'>No posts to show.</p>";
    }

    $conn->close();
    ?>
</div>
</body>
</html>