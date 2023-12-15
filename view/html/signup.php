<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/stylelogin.css">
    <title>Sign up to DeadlineMu</title>
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="../assets/images/DeadlineMu.jpg" alt="Your Logo">
        </div>
        <div class="header-text">
          <h1 class="logo-text">DeadlineMu</h2>
        </div>
    </header>
    <div class="wrapper text-center">
        <h1 class="login-title">Sign up to <span class="logo-title">DeadlineMu</span></h1>
        <form action="/signup" method="post">
            <label class="label-text">Username</label>
            <input type="text" name="username">
            <label class="label-text">Password</label>
            <input type="password" name="password">
            <button type="submit">Create!</button>
        </form>
        <div class="create">
            I already have an account, <a href="login.php">Log in!</a>
        </div>
    </div>
</body>
</html> 