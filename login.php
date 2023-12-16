<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DeadlineMU</title>
</head>

<body>
    <h2>Login</h2>
    
    <?php
    session_start();

    // Check if the user is already logged in
    if (isset($_SESSION['user_id'])) {
        header("Location: homepage.php");
        exit();
    }

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include('connection.php'); // Include your database connection file

        $username = $_POST['username'];
        $password = $_POST['password'];

        // Perform user authentication
        $sql = "SELECT * FROM deadlinemu.User WHERE Username = '$username' AND Password = '$password'";
        $result = mysqli_query($connection, $sql);

        if ($result && mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);

            // Set user information in the session
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];

            header("Location: homepage.php");
            exit();
        } else {
            echo "Invalid username or password.";
        }
    }
    ?>

    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>

        <br>

        <label for="password">Password:</label>
        <input type="password" name="password" required>

        <br>

        <button type="submit">Login</button>
    </form>
</body>

</html>
