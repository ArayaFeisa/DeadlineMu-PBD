<?php
include('connection.php');

// Fungsi untuk menghapus tugas
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $deleteSql = "DELETE FROM deadlinemu.Task WHERE TaskID = $taskId";

    if (mysqli_query($connection, $deleteSql)) {
        header("Location: task.php");
        exit();
    } else {
        die("Error deleting task: " . mysqli_error($connection));
    }
}

// Menangani tindakan bookmark
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle bookmark action
    if (isset($_POST['action']) && $_POST['action'] == 'bookmark' && isset($_POST['taskID'])) {
        $taskID = $_POST['taskID'];
        $userID = $_POST['userID'];

        // Cek apakah tugas sudah di-bookmark
        $checkBookmarkSql = "SELECT * FROM deadlinemu.Bookmark WHERE UserID = $userID AND TaskID = $taskID";
        $checkBookmarkResult = mysqli_query($connection, $checkBookmarkSql);

        if (mysqli_num_rows($checkBookmarkResult) == 0) {
            // Jika belum di-bookmark, masukkan ke dalam tabel Bookmark
            $insertBookmarkSql = "INSERT INTO deadlinemu.Bookmark (UserID, TaskID) VALUES ($userID, $taskID)";
            mysqli_query($connection, $insertBookmarkSql);
        } else {
            // Jika sudah di-bookmark, hapus dari tabel Bookmark
            $deleteBookmarkSql = "DELETE FROM deadlinemu.Bookmark WHERE UserID = $userID AND TaskID = $taskID";
            mysqli_query($connection, $deleteBookmarkSql);
        }
    }
}

// Query untuk mengambil data tugas
$sql = "SELECT * FROM deadlinemu.Task";
$result = mysqli_query($connection, $sql);

// Memeriksa apakah query berhasil dieksekusi
if (!$result) {
    die("Error fetching tasks: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeadlineMU - Task</title>
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
        <h2 class="mt-5 mb-3">Task</h2>
        <a href="v_addtask.php" class="btn btn-primary my-3">Add New Task</a>
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
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>Bookmark</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Menampilkan data tugas
                if (mysqli_num_rows($result) > 0) {
                    $count = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        $taskID = $row['TaskID'];
                        $title = $row['Title'];
                        $description = $row['Description'];
                        $dueDate = $row['DueDate'];
                        $priority = $row['Priority'];
                        $status = $row['Status'];
                        $userID = $row['UserID'];
                        $categoryID = $row['CategoryID'];

                        // Cek apakah tugas di-bookmark
                        $checkBookmarkSql = "SELECT * FROM deadlinemu.Bookmark WHERE UserID = $userID AND TaskID = $taskID";
                        $checkBookmarkResult = mysqli_query($connection, $checkBookmarkSql);

                        $isBookmarked = mysqli_num_rows($checkBookmarkResult) > 0;

                        echo "<tr>
                                <td>{$count}</td>
                                <td>{$title}</td>
                                <td>{$description}</td>
                                <td>{$dueDate}</td>
                                <td>{$priority}</td>
                                <td>{$status}</td>
                                <td>{$userID}</td>
                                <td>{$categoryID}</td>
                                <td><a href='v_edittask.php?id={$taskID}' class='btn btn-warning'>Edit</a></td>
                                <td><a href='task.php?action=delete&id={$taskID}' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                                <td>
                                    <form method='post' action='task.php'>
                                        <input type='hidden' name='taskID' value='$taskID'>
                                        <input type='hidden' name='userID' value='$userID'>
                                        <button type='submit' name='action' value='bookmark' class='btn " . ($isBookmarked ? "btn-success" : "btn-outline-success") . "'>
                                            " . ($isBookmarked ? "Bookmarked" : "Bookmark") . "
                                        </button>
                                    </form>
                                </td>
                            </tr>";
                        $count++;
                    }
                } else {
                    echo "<tr><td colspan='11'>No tasks found</td></tr>";
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
