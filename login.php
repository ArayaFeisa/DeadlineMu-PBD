<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/stylelogin.css">
    <title>Log in to DeadlineMU</title>
    
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
        <h1 class="login-title">Log in to <span class="logo-title">DeadlineMu</span></h1>
        <form action="/login" method="post">
            <label class="label-text">Username</label>
            <input type="text" name="username">
            <label class="label-text">Password</label>
            <input type="password" name="password">
            <button type="submit">Let's Started</button>
        </form>
        <div class="create">
            Don't have an account? <a href="signup.php">Sign up</a>
        </div>
    </div>
</body>
</html> 