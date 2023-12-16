<?php
include('connection.php');

// Query untuk mendapatkan task yang dibookmark oleh pengguna
$userID = 1; // Gantilah dengan ID pengguna yang sesuai
$sql = "SELECT T.* FROM deadlinemu.Task T
        JOIN deadlinemu.Bookmark B ON T.TaskID = B.TaskID
        WHERE B.UserID = $userID";
$result = mysqli_query($connection, $sql);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Error fetching bookmarked tasks: " . mysqli_error($connection));
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
        <h2 class="mt-5 mb-3">Bookmarked Tasks</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>User ID</th>
                    <th>Category ID</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data tugas yang dibookmark
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$count}</td>
                                <td>{$row['Title']}</td>
                                <td>{$row['Description']}</td>
                                <td>{$row['DueDate']}</td>
                                <td>{$row['Priority']}</td>
                                <td>{$row['Status']}</td>
                                <td>{$row['UserID']}</td>
                                <td>{$row['CategoryID']}</td>
                              </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='8'>No bookmarked tasks found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>
</body>

</html>
