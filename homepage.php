<?php
include('connection.php');

// Fungsi untuk menghapus kategori
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $categoryId = $_GET['id'];
    $deleteSql = "DELETE FROM deadlinemu.Category WHERE CategoryID = $categoryId";
    
    if (mysqli_query($connection, $deleteSql)) {
        header("Location: category.php");
        exit();
    } else {
        die("Error deleting category: " . mysqli_error($connection));
    }
}

// Query untuk mengambil data kategori
$sql = "SELECT * FROM deadlinemu.Category";
$result = mysqli_query($connection, $sql);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Error fetching categories: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="stylecategory.css">
</head>

<body>
    <div class="sidebar">
        <div class="brand">
            DeadlineMU
        </div>
        <a href="homepage.php" class="active">Home</a>
        <a href="task.php">Task</a>
        <a href="category.php">Category</a>
        <a href="task_and_category.php">Task and Category</a>
        <a href="activity_log.php">Task Log</a>
        <a href="bookmark.php">Bookmark</a>
        <a href="#">Logout</a>
    </div>

    <div class="container">
        <p>Hello</p>
        <p>Nana</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>
