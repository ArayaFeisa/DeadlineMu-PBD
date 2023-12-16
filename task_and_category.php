<?php
include('connection.php');

// Query untuk mengambil semua kategori
$categorySql = "SELECT * FROM deadlinemu.Category";
$categoryResult = mysqli_query($connection, $categorySql);

// Memeriksa apakah query berhasil dieksekusi
if (!$categoryResult) {
    die("Error fetching categories: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Task and Category</title>
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
        <a href="#">Task Log</a>
        <a href="bookmark.php">Bookmark</a>
        <a href="#">Logout</a>
    </div>
    <div class="container">
        <h2 class="mt-5 mb-3">Task and Category</h2>

        <!-- Tampilkan semua kategori -->
        <?php
        while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
            $categoryID = $categoryRow['CategoryID'];
            $categoryName = $categoryRow['CategoryName'];

            echo "<h3>$categoryName</h3>";

            // Query untuk mengambil tugas berdasarkan kategori
            $taskSql = "SELECT * FROM deadlinemu.Task WHERE CategoryID = $categoryID";
            $taskResult = mysqli_query($connection, $taskSql);

            // Memeriksa apakah query berhasil dieksekusi
            if (!$taskResult) {
                die("Error fetching tasks: " . mysqli_error($connection));
            }

            echo "<table class='table'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Description</th>
                            <!-- Tambahkan kolom-kolom lain sesuai kebutuhan -->
                        </tr>
                    </thead>
                    <tbody>";

            // Menampilkan data tugas
            if (mysqli_num_rows($taskResult) > 0) {
                $count = 1;
                while ($taskRow = mysqli_fetch_assoc($taskResult)) {
                    echo "<tr>
                            <td>{$count}</td>
                            <td>{$taskRow['Title']}</td>
                            <td>{$taskRow['Description']}</td>
                            <!-- Tambahkan kolom-kolom lain sesuai kebutuhan -->
                        </tr>";
                    $count++;
                }
            } else {
                echo "<tr><td colspan='3'>No tasks found</td></tr>";
            }

            echo "</tbody></table>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>
</html>
